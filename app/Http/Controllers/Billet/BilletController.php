<?php

namespace App\Http\Controllers\Billet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Billet\Billet;
use App\Models\Billet\Archive;
use App\Models\Billet\Source;
use App\Models\Billet\Category;
use App\Models\User\User;
use App\Models\Billet\Revision;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


class BilletController extends Controller
{
  /**
     * The default page length for the datatable
     *
     * @var int
     */
  public $defaultPageLength =25;
     /**
     * The entries for the datatable
     *
     * @var array
     */
     public $entries=[25,50,100];
     /**
     * Protecting routes
     */
     public function __construct()
     {
       $this->middleware(['auth','activeUser']);
     }
     
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response with : results of ItemsList action $result, actions for the datatable $actions
     */  
    public function index(Request $request)
    {
      $view='billet.billets.administrator.index';
      $queryWithPaginate=Billet::with(['getAuthor:id,name','getCategory'])->where('published','<>',2)->orderBy('published', 'asc')->paginate($this->defaultPageLength,['id','title','category_id','published','featured','source_id','created_by','created_at','image','views']);
      $queryWithOutPaginate =Billet::with(['getAuthor:id,name','getCategory'])
      ->join('users', 'billets.created_by', '=', 'users.id')
      ->join('billet_categories', 'billets.category_id', '=', 'billet_categories.id')
      ->where('billets.published','<>',2);
      $controllerMethodUrl=action('Billet\BilletController@index');
      $actions=Billet::indexActions();
      $result=$this->itemsList($request,$queryWithPaginate,$queryWithOutPaginate,$controllerMethodUrl);
      return view($view,$result,$actions);


    }
/**
     * get the list of items.
     * @param  \Illuminate\Http\Request  $request, a query with pagination $queryWithPaginate, a query without pagination *$queryWithOutPaginate, a controller methode url $controllerMethodUrl
     *
     * @return  the result of filter action
     */
public function itemsList($request,$queryWithPaginate,$queryWithOutPaginate,$controllerMethodUrl)
{

  if((url()->full() ==  $controllerMethodUrl || (url()->full() !=  $controllerMethodUrl && !($request->pageLength)))){
    $result=$this->itemsWithTableParameters($queryWithPaginate);
    return $result;
  } else {
    $pageLength=$request->pageLength;
    $searchByTitle=$request->searchByTitle;
    $searchByCategory=$request->searchByCategory;
    $searchByFeaturedState=$request->searchByFeaturedState;
    $searchByPublishedState=$request->searchByPublishedState;
    $searchByUser=$request->searchByUser;
    $fromDate=$request->fromDate;  
    $toDate=$request->toDate;
    $sortField=$request->sortField;
    $order=$request->order;
    $itemType=$request->itemType;
    $items = $queryWithOutPaginate;
    $filterResult=$this->filter($items,$pageLength,$searchByTitle,$searchByCategory,$searchByFeaturedState,$searchByPublishedState,$searchByUser, $fromDate,$toDate,$sortField,$order,$itemType);
    return $filterResult;

  }

}
/**
     * get parameters for datatable.
     * @param  items collection $items, 
     *
     * @return items collection  $items, datatable information $tableInfo, datatable entries $entries, items categories $categoies, users $users 
     **/
public function itemsWithTableParameters($items){
  $numberOfItemSFound=$items->count();
  if($numberOfItemSFound==0){
    $tableInfo="Affichage de 0 à ".$numberOfItemSFound." lignes sur ".$items->total();
  }else{
    $tableInfo="Affichage de 1 à ".$numberOfItemSFound." lignes sur ".$items->total();

  }
  $entries=$this->entries;
  $categories= Category::where('published','<>',2)->get(['id','title']);
  $users= User::get(['id','name']); 
  return compact('items','tableInfo','entries','categories','users');
}

    /**
    * search and sort datatable items
    *@param  \Illuminate\Http\Request $request
    *@return \Illuminate\Http\Response with : results of filter action, actions for datatable
    */
    public function searchAndSort(Request $request){ 
     $data=json_decode($request->getContent());
     $pageLength=$data->entries;
     $searchByTitle= $data->searchByTitle;
     $searchByCategory= $data->searchByCategory;
     $searchByFeaturedState= $data->searchByFeaturedState;
     $searchByPublishedState= $data->searchByPublishedState;
     $searchByUser=$data->searchByUser;
     $fromDate=$data->fromDate ? date("Y-m-d H:i:s", strtotime($data->fromDate)) : null;
     $toDate=$data->toDate ? date("Y-m-d H:i:s", strtotime( $data->toDate)) : null;
     $sortField=$data->sortField;
     $order=$data->order;
     $itemType=$data->itemType;

     switch ($itemType) {
      case('billets'):
      $items = Billet::with(['getAuthor:id,name','getCategory'])
      ->join('users', 'billets.created_by', '=', 'users.id')
      ->join('billet_categories', 'billets.category_id', '=', 'billet_categories.id')
      ->where('billets.published','<>',2);
      $actions=Billet::indexActions();
      break;
      case('billet-trash'):
      $items=Billet::onlyTrashed()->with(['getAuthor:id,name','getCategory'])
      ->join('users', 'billets.created_by', '=', 'users.id')
      ->join('billet_categories', 'billets.category_id', '=', 'billet_categories.id');
      $actions=Billet::trashActions();
      break;

      case('billet-draft'):
      $items=Billet::with(['getAuthor:id,name','getCategory'])
      ->join('users', 'billets.created_by', '=', 'users.id')
      ->join('billet_categories', 'billets.category_id', '=', 'billet_categories.id')
      ->where('billets.published',2);
      $actions=Billet::draftActions();
      break;
    }

    $filterResult=$this->filter($items,$pageLength,$searchByTitle,$searchByCategory,$searchByFeaturedState,$searchByPublishedState,$searchByUser,
     $fromDate,$toDate ,$sortField,$order,$itemType);
    return view('billet.billets.administrator.searchAndSort',$filterResult,$actions);

  }
/**
*filter datatable
*@param items collection $items, number of items par page $pageLength, value of search fields: $searchByTitle, $searchByCategory, $searchByFeaturedState , $searchByPublishedState, $searchByUser, $fromDate, $toDate, $sortField, $order, itemType
*
*@return tems collection $items, number of items par page $pageLength, value of search fields: $searchByTitle, $searchByCategory, $searchByFeaturedState , $searchByPublishedState, $searchByUser, $fromDate, $toDate, $sortField, $order, itemType
**/
public function filter($items,$pageLength,$searchByTitle,$searchByCategory,$searchByFeaturedState,$searchByPublishedState,
  $searchByUser,$fromDate,$toDate,$sortField,$order,$itemType) {
  if($searchByTitle){
    $items =$items->ofTitle($searchByTitle);
  }
  if($searchByCategory){
    $items =$items->ofCategory($searchByCategory);
  }
  
  if(!is_null($searchByFeaturedState)){
    $items =$items->ofFeaturedState($searchByFeaturedState);   
  }
  if(!is_null($searchByPublishedState)){
    $items =$items->ofPublishedState($searchByPublishedState);   
  }
  if($searchByUser){
    $items =$items->ofUser($searchByUser);   
  }
  if($fromDate && !$toDate){ 
    $items =$items->ofFromDate($fromDate);   
  }
  if(!$fromDate && $toDate){ 
    $items =$items->ofToDate($toDate);
  }
  if($fromDate && $toDate){
    $items =$items->ofBetweenTwoDate($fromDate, $toDate);
  }

  if($sortField){
    $items = $items->orderBy($sortField, $order)->select('billets.id','billets.title','billets.category_id','billets.published','billets.featured','billets.source_id','billets.created_by','billets.created_at','billets.image','billets.views', 'billet_categories.title as category','users.name as author')->paginate($pageLength);
  }else{
    $items = $items->orderBy('published', 'asc')->select('billets.id','billets.title','billets.category_id','billets.published','billets.featured','billets.source_id','billets.created_by','billets.created_at','billets.image','billets.views', 'billet_categories.title as category','users.name as author')->paginate($pageLength);
  }
  if($itemType){
    if($itemType=='billets'){ $items->withPath('billets');};
    if($itemType=='billet-trash'){ $items->withPath('trash');};
    if($itemType=='billet-draft'){ $items->withPath('draft');};

  }

  $items->appends([
    'pageLength' => $pageLength,
    'searchByTitle' => $searchByTitle,
    'searchByCategory' => $searchByCategory,
    'searchByFeaturedState' => $searchByFeaturedState,
    'searchByPublishedState' => $searchByPublishedState,
    'searchByUser' => $searchByUser,
    'fromDate' => $fromDate,
    'toDate' => $toDate,
    'sortField' => $sortField,
    'itemType'=>$itemType,
    'order' => $order])->links();
  $numberOfItemSFound=$items->count();
  if($numberOfItemSFound==0){
    $tableInfo="Affichage de 0 à ".$numberOfItemSFound." lignes sur ".$items->total();
  }else{
    $tableInfo="Affichage de 1 à ".$numberOfItemSFound." lignes sur ".$items->total();

  }
  $entries=$this->entries;
  $categories= Category::where('published','<>',2)->get(['id','title']);
  $users= User::get(['id','name']);

  return compact('items','tableInfo','entries','categories','users','searchByTitle','searchByCategory','searchByFeaturedState','searchByPublishedState','searchByUser','fromDate','toDate');

}

  /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
  public function create()
  {
    $sources=Source::where('published',1)->get(['id','title']);
    $categories=Category::where('published',1)->get(['id','title']);
    $users=user::all('id','name');
    $auth_username = Auth::user()->name;
    return view('billet.billets.administrator.create',['sources'=>$sources, 'categories'=>$categories,'auth_username'=>$auth_username, 'users'=>$users]);
  }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $validatedData = $request->validate([
        'ontitle'=>'nullable|string',
        'title' => 'required|string',
        'category'=>'required|int',
        'published'=>'nullable',
        'featured'=>'nullable',
        'image'=>'nullable|image',
        'image_legend'=>'nullable|string',
        'introtext'=>'nullable|string',
        'fulltext'=>'required|string',
        'source_id'=>'int',
        // 'created_by'=>'int',
        'start_publication_at'=>'nullable|date_format:d-m-Y H:i:s',
        'stop_publication_at'=>'nullable|date_format:d-m-Y H:i:s',

      ]);

      $billet= new Billet;
      $billet->ontitle = $request->ontitle;
      $billet->title =$request->title;
      $billet->alias =str_slug($request->title, '-');
      $billet->category_id = $request->category;
      $billet->published=$request->published ? $request->published : 0 ;
      $billet->featured=$request->featured ? $request->featured : 0 ;
      $billet->image = $request->image;
      $billet->image_legend =$request->image_legend;
      $billet->introtext = $request->introtext;
      $billet->fulltext =$request->fulltext;
      $billet->source_id = $request->source;
      $billet->keywords = $request->tags;
      $billet->created_by =$request->created_by ?? $request->auth_userid;
      $billet->created_at =now();
      if($request->start_publication_at){
       $start_at=explode(' ',$request->start_publication_at);
       $billet->start_publication_at = date("Y-m-d", strtotime($start_at[0])).' '.$start_at[1];
     }else{
      $billet->start_publication_at=$request->start_publication_at;
    }
    if($request->start_publication_at){
     $stop_at=explode(' ',$request->stop_publication_at);
     $billet->stop_publication_at = date("Y-m-d", strtotime($stop_at[0])).' '.$stop_at[1];
   }else{
    $billet->stop_publication_at=$request->stop_publication_at;
  }



  try {
   DB::transaction(function () use ($billet) {
     $billet->save();
     $lastRecord= Billet::latest()->first();
     $archive= new Archive;
     $archive->id = $lastRecord->id;
     $archive->ontitle = $lastRecord->ontitle;
     $archive->title =$lastRecord->title;
     $archive->alias =$lastRecord->alias;
     $archive->category_id = $lastRecord->category_id;
     $archive->published = $lastRecord->published;
     $archive->featured =$lastRecord->featured;
     $archive->image = $lastRecord->image;
     $archive->image_legend =$lastRecord->image_legend;
     $archive->introtext = $lastRecord->introtext;
     $archive->fulltext =$lastRecord->fulltext;
     $archive->source_id = $lastRecord->source_id;
     $archive->keywords=$lastRecord->keywords;
     $archive->created_by =$lastRecord->created_by;
     $archive->created_at =$lastRecord->created_at;
     $archive->start_publication_at = $lastRecord->start_publication_at;
     $archive->stop_publication_at =$lastRecord->stop_publication_at;
     $archive->save();
     $oldest = Billet::oldest()->first();
     $oldest->delete();
   });
   
 } catch (Exception $exc) {
  session()->flash('message.type', 'danger');
  session()->flash('message.content', 'Erreur lors de l\'ajout!');
//           echo $exc->getTraceAsString();
}

session()->flash('message.type', 'success');
session()->flash('message.content', 'Billet ajouté avec succès!');


if ($request->save_close) {
     // return redirect(session()->get('link'));
  return redirect()->route('billets.index');

}else{
  return redirect()->route('billets.create');
}


}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
     $billet= Billet::with(['getAuthor:id,name','getCategory'])->where('id',$id)->get();
     if (blank($billet)) {
      $billet= Archive::with(['getAuthor:id,name','getCategory'])->where('id',$id)->get();
    }

    if(blank($billet)){
      dd('billet not find');
    }

    foreach ($billet as $billet) {
        # code...
     $billet->views=$billet->views + 1 ;
     $billet->save();
   }
   return view('billet.billets.public.show',compact('billet'));
 }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

      $billet=Billet::find($id);
      $archive=Archive::find($id);
      if(!is_null($billet)){
        if($billet->checkout==0 || $billet->checkout==Auth::id()){
          $billet->checkout=Auth::id();
          $archive->checkout=Auth::id();
          $billet->save();
          $archive->save();
          $sources=Source::where('published',1)->get(['id','title']);
          $categories=Category::where('published',1)->get(['id','title']);
          $users=user::all('id','name');
          return view('billet.billets.administrator.edit',compact('billet','sources','categories','users'));
        }elseif ($billet->checkout!=0 && $billet->checkout!=Auth::id()) {
         session()->flash('message.type', 'warning');
         session()->flash('message.content', 'Billet dejà en cour de modification!');
         return redirect()->route('billets.index');
       }
     } else{
      return redirect()->route('billet-archives.edit',compact('id'));
    }
  }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $validatedData = $request->validate([
        'ontitle'=>'nullable|string',
        'title' => 'required|string',
        'category'=>'required|int',
        'published'=>'nullable',
        'featured'=>'nullable',
        'image'=>'nullable|image',
        'image_legend'=>'nullable|string',
        'introtext'=>'nullable|string',
        'fulltext'=>'required|string',
        'source_id'=>'int',
        // 'created_by'=>'int',
        'start_publication_at'=>'nullable|date_format:d-m-Y H:i:s',
        'stop_publication_at'=>'nullable|date_format:d-m-Y H:i:s',

      ]);
      $billet=Billet::find($id);
      if (is_null($billet)) {
       $billet=Archive::find($id);
     }
     $billet->ontitle = $request->ontitle;
     $billet->title =$request->title;
     $billet->alias =str_slug($request->title, '-');
     $billet->category_id = $request->category;
     $billet->published=$request->published ? $request->published : 0;
     $billet->featured=$request->featured ? $request->featured : 0 ; 
     $billet->image = $request->image;
     $billet->image_legend =$request->image_legend;
     $billet->introtext = $request->introtext;
     $billet->fulltext =$request->fulltext;
     $billet->source_id = $request->source;
     $billet->keywords = $request->tags;
     $billet->created_by =$request->created_by ?? $request->auth_userid;
     $billet->created_at =now();
     if($request->start_publication_at){
       $start_at=explode(' ',$request->start_publication_at);
       $billet->start_publication_at = date("Y-m-d", strtotime($start_at[0])).' '.$start_at[1];
     }else{
      $billet->start_publication_at=$request->start_publication_at;
    }
    if($request->start_publication_at){
     $stop_at=explode(' ',$request->stop_publication_at);
     $billet->stop_publication_at = date("Y-m-d", strtotime($stop_at[0])).' '.$stop_at[1];
   }else{
    $billet->stop_publication_at=$request->stop_publication_at;
  }
  $billet->checkout=0;

  try {
   DB::transaction(function () use ($billet,$request) {
     $archive= Archive::find($billet->id);
     $archive->ontitle = $billet->ontitle;
     $archive->title =$billet->title;
     $archive->alias =$billet->alias;
     $archive->category_id = $billet->category_id;
     $archive->published = $billet->published;
     $archive->featured =$billet->featured;
     $archive->image = $billet->image;
     $archive->image_legend =$billet->image_legend;
     $archive->introtext = $billet->introtext;
     $archive->fulltext =$billet->fulltext;
     $archive->source_id = $billet->source_id;
     $archive->keywords=$billet->keywords;
     $archive->created_by =$billet->created_by;
     $archive->created_at =$billet->created_at;
     $archive->start_publication_at = $billet->start_publication_at;
     $archive->stop_publication_at =$billet->stop_publication_at;
     $archive->checkout=0;

     if ($request->update) {
       $billet->save();
       $archive->save();
       $revision= new  Revision;
       $revision->type=explode('@', Route::CurrentRouteAction())[1];
       $revision->user_id=Auth::id();
       $revision->billet_id=$billet->id;
       $revision->revised_at=now();
       $revision->save();
       session()->flash('message.type', 'success');
       session()->flash('message.content', 'Billet modifié avec succès!');
       
     }else{
      session()->flash('message.type', 'danger');
      session()->flash('message.content', 'Modification annulée!');
    }
  });
   
 } catch (Exception $exc) {
  session()->flash('message.type', 'danger');
  session()->flash('message.content', 'Erreur lors de la modification!');
//           echo $exc->getTraceAsString();
}
return redirect()->route('billets.index');

}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     $revisions= Revision::where('billet_id',$id)->get(['id']);
     foreach ($revisions as $r) {
      $r->delete();
    }
    $billet=Billet::onlyTrashed()->find($id)->forceDelete();
    $archive=Archive::onlyTrashed()->find($id)->forceDelete();
    session()->flash('message.type', 'success');
    session()->flash('message.content', 'Billet supprimé avec success!');
    return redirect()->route('billets.trash');
  }
    /**
     * put the specified resource in the draft.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function putInDraft($id)
    {
      try {
       DB::transaction(function () use ($id) {
        $billet=Billet::find($id);
        $archive=Archive::find($id);
        $billet->published=2;
        $archive->published=2;
        $billet->save();
        $archive->save();
        $revision= new  Revision;
        $revision->type=explode('@', Route::CurrentRouteAction())[1];
        $revision->user_id=Auth::id();
        $revision->billet_id=$id;
        $revision->revised_at=now();
        $revision->save();
      });
       session()->flash('message.type', 'success');
       session()->flash('message.content', 'Billet mis au brouillon!');
     } catch (Exception $exc) {
      session()->flash('message.type', 'danger');
      session()->flash('message.content', 'Erreur lors de la mise au brouillon!');
//           echo $exc->getTraceAsString();
    }
    return redirect()->route('billets.index');
  }
/**
     * put the specified resource in the trash.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function putInTrash($id)
{
  try {
   DB::transaction(function () use ($id) {
    $billet=Billet::find($id)->delete();
    $archive=Archive::find($id)->delete();
    $revision= new  Revision;
    $revision->type=explode('@', Route::CurrentRouteAction())[1];
    $revision->user_id=Auth::id();
    $revision->billet_id=$id;
    $revision->revised_at=now();
    $revision->save();
  });
   session()->flash('message.type', 'success');
   session()->flash('message.content', 'Billet mis en corbeille!');
 } catch (Exception $exc) {
  session()->flash('message.type', 'danger');
  session()->flash('message.content', 'Erreur lors de la mise en corbeille!');
//           echo $exc->getTraceAsString();
}
return redirect()->route('billets.index');
}
/**
     * restore the specified resource from the trash.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function restore($id)
{
  try {
   DB::transaction(function () use ($id) {
    $billet=Billet::onlyTrashed()->find($id)->restore();
    $archive=Archive::onlyTrashed()->find($id)->restore();
    $revision= new  Revision;
    $revision->type=explode('@', Route::CurrentRouteAction())[1];
    $revision->user_id=Auth::id();
    $revision->billet_id=$id;
    $revision->revised_at=now();
    $revision->save();
  });
   session()->flash('message.type', 'success');
   session()->flash('message.content', 'Billet restaurer!');

 } catch (Exception $exc) {
  session()->flash('message.type', 'danger');
  session()->flash('message.content', 'Erreur lors de la restauration!');
//           echo $exc->getTraceAsString();
}
return redirect()->route('billets.trash');
}

/**
     * Display a listing of the resource in the trash.
     *
     * @return \Illuminate\Http\Response
     */
public function inTrash(Request $request)
{
  $view='billet.billets.administrator.trash';
  $queryWithPaginate=Billet::onlyTrashed()->with(['getAuthor:id,name','getCategory'])
  ->join('users', 'billets.created_by', '=', 'users.id')
  ->join('billet_categories', 'billets.category_id', '=', 'billet_categories.id')
  ->select('billets.id','billets.title','billets.category_id','billets.published','billets.featured','billets.source_id','billets.created_by','billets.created_at','billets.image','billets.views', 'billet_categories.title as category','users.name as author')
  ->orderBy('billets.id', 'desc')->paginate($this->defaultPageLength);
  $queryWithOutPaginate =Billet::onlyTrashed()->with(['getAuthor:id,name','getCategory'])
  ->join('users', 'billets.created_by', '=', 'users.id')
  ->join('billet_categories', 'billets.category_id', '=', 'billet_categories.id')
  ->select('billets.id','billets.title','billets.category_id','billets.published','billets.featured','billets.source_id','billets.created_by','billets.created_at','billets.image','billets.views', 'billet_categories.title as category','users.name as author');
  $controllerMethodUrl=action('Billet\BilletController@inTrash');
  $actions=Billet::trashActions();
  $result=$this->itemsList($request,$queryWithPaginate,$queryWithOutPaginate,$controllerMethodUrl);
  return view($view,$result,$actions);
}
/**
     * Display a listing of the resource in the draft.
     *
     * @return \Illuminate\Http\Response
     */
public function inDraft( Request $request)
{
  $view='billet.billets.administrator.draft';
  $queryWithPaginate=Billet::with(['getAuthor:id,name','getCategory'])
  ->join('users', 'billets.created_by', '=', 'users.id')
  ->join('billet_categories', 'billets.category_id', '=', 'billet_categories.id')
  ->select('billets.id','billets.title','billets.category_id','billets.published','billets.featured','billets.source_id','billets.created_by','billets.created_at','billets.image','billets.views', 'billet_categories.title as category','users.name as author')
  ->where('billets.published',2)
  ->orderBy('billets.id', 'desc')->paginate($this->defaultPageLength);
  $queryWithOutPaginate =Billet::with(['getAuthor:id,name','getCategory'])
  ->join('users', 'billets.created_by', '=', 'users.id')
  ->join('billet_categories', 'billets.category_id', '=', 'billet_categories.id')
  ->select('billets.id','billets.title','billets.category_id','billets.published','billets.featured','billets.source_id','billets.created_by','billets.created_at','billets.image','billets.views', 'billet_categories.title as category','users.name as author')->where('billets.published',2);
  $controllerMethodUrl=action('Billet\BilletController@inDraft');
  $actions=Billet::draftActions();
  $result=$this->itemsList($request,$queryWithPaginate,$queryWithOutPaginate,$controllerMethodUrl);
  return view($view,$result,$actions);
}

}
