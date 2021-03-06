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

class ArchiveController extends Controller
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
      $view='billet.archives.administrator.index';
      $queryWithPaginate=Archive::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory'])->where('published','<>',2)->orderBy('published', 'asc')->paginate($this->defaultPageLength,['id','title','category_id','published','featured','source_id','created_by','created_at','image','views']);
      $queryWithOutPaginate =Archive::with(['getAuthor:id,name','getCategory'])
      ->join('users', 'billet_archives.created_by', '=', 'users.id')
      ->join('billet_categories', 'billet_archives.category_id', '=', 'billet_categories.id')
      ->where('billet_archives.published','<>',2);
      $controllerMethodUrl=action('Billet\ArchiveController@index');
      $actions=Archive::indexActions();
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
        case('billet-archives'):
        $items = Archive::with(['getAuthor:id,name','getCategory'])
        ->join('users', 'billet_archives.created_by', '=', 'users.id')
        ->join('billet_categories', 'billet_archives.category_id', '=', 'billet_categories.id')
        ->where('billet_archives.published','<>',2);
        $actions=Archive::indexActions();
        break;
        case('billet-archive-trash'):
        $items=Archive::onlyTrashed()->with(['getAuthor:id,name','getCategory'])
        ->join('users', 'billet_archives.created_by', '=', 'users.id')
        ->join('billet_categories', 'billet_archives.category_id', '=', 'billet_categories.id');
        $actions=Archive::trashActions();
        break;

        case('billet-archive-draft'):
        $items=Archive::with(['getAuthor:id,name','getCategory'])
        ->join('users', 'billet_archives.created_by', '=', 'users.id')
        ->join('billet_categories', 'billet_archives.category_id', '=', 'billet_categories.id')
        ->where('billet_archives.published',2);
        $actions=Archive::draftActions();
        break;
      }

      $filterResult=$this->filter($items,$pageLength,$searchByTitle,$searchByCategory,$searchByFeaturedState,$searchByPublishedState,$searchByUser,
       $fromDate,$toDate ,$sortField,$order,$itemType);
      return view('billet.archives.administrator.searchAndSort',$filterResult,$actions);

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
    $items = $items->orderBy($sortField, $order)->select('billet_archives.id','billet_archives.title','billet_archives.category_id','billet_archives.published','billet_archives.featured','billet_archives.source_id','billet_archives.created_by','billet_archives.created_at','billet_archives.image','billet_archives.views', 'billet_categories.title as category','users.name as author')->paginate($pageLength);
  }else{
    $items = $items->orderBy('published', 'asc')->select('billet_archives.id','billet_archives.title','billet_archives.category_id','billet_archives.published','billet_archives.featured','billet_archives.source_id','billet_archives.created_by','billet_archives.created_at','billet_archives.image','billet_archives.views', 'billet_categories.title as category','users.name as author')->paginate($pageLength);
  }
  if($itemType){
    if($itemType=='billet-archives'){ $items->withPath('billet-archives');};
    if($itemType=='billet-archive-trash'){ $items->withPath('trash');};
    if($itemType=='billet-archive-draft'){ $items->withPath('draft');};

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     if ($billet) {
      return redirect()->route('billets.edit',compact('billet'));
    }else{
      $archive=Archive::find($id);
      if(is_null($archive)){
        die('impossible d\'acceder à la resource demander');
      }else{
        if($archive->checkout==0 || $archive->checkout==Auth::id()){
          $archive->checkout=Auth::id();
          $archive->save();
          $sources=Source::where('published',1)->get(['id','title']);
          $categories=Category::where('published',1)->get(['id','title']);
          $users=user::all('id','name');
          return view('billet.archives.administrator.edit',compact('archive','sources','categories','users'));
        }elseif ($archive->checkout!=0 && $archive->checkout!=Auth::id()) {
          session()->flash('message.type', 'warning');
          session()->flash('message.content', 'Billet dejà en cour de modification!');
          return redirect()->route('billet-archives.index');
        }
      }
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
     
     $archive=Archive::find($id);
     $archive->ontitle = $request->ontitle;
     $archive->title =$request->title;
     $archive->alias =str_slug($request->title, '-');
     $archive->category_id = $request->category;
     $archive->published=$request->published ? $request->published : 0;
     $archive->featured=$request->featured ? $request->featured : 0 ; 
     $archive->image = $request->image;
     $archive->image_legend =$request->image_legend;
     $archive->introtext = $request->introtext;
     $archive->fulltext =$request->fulltext;
     $archive->source_id = $request->source;
     $archive->keywords = $request->tags;
     $archive->created_by =$request->created_by ?? $request->auth_userid;
     $archive->created_at =now();
     if($request->start_publication_at){
       $start_at=explode(' ',$request->start_publication_at);
       $archive->start_publication_at = date("Y-m-d", strtotime($start_at[0])).' '.$start_at[1];
     }else{
      $archive->start_publication_at=$request->start_publication_at;
    }
    if($request->start_publication_at){
     $stop_at=explode(' ',$request->stop_publication_at);
     $archive->stop_publication_at = date("Y-m-d", strtotime($stop_at[0])).' '.$stop_at[1];
   }else{
    $archive->stop_publication_at=$request->stop_publication_at;
  }
  $archive->checkout=0;

  if ($request->update) {
   $archive->save();
   $revision= new  Revision;
   $revision->type=explode('@', Route::CurrentRouteAction())[1];
   $revision->user_id=Auth::id();
   $revision->billet_id=$archive->id;
   $revision->revised_at=now();
   $revision->save();
   session()->flash('message.type', 'success');
   session()->flash('message.content', 'modifié avec succès!');
   
 }else{
  session()->flash('message.type', 'danger');
  session()->flash('message.content', 'Modification annulée!');
}


return redirect()->route('billet-archives.index');

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
    $billet=Billet::onlyTrashed()->find($id);
    if($billet){
     $billet=Billet::onlyTrashed()->find($id)->forceDelete();
     $archive=Archive::onlyTrashed()->find($id)->forceDelete();
     session()->flash('message.type', 'success');
     session()->flash('message.content', 'Billet supprimé avec success!');
     return redirect()->route('billet-archives.trash');
   }else{
    $archive=Archive::onlyTrashed()->find($id)->forceDelete();
    session()->flash('message.type', 'success');
    session()->flash('message.content', 'Billet supprimé avec success!');
    return redirect()->route('billet-archives.trash');
  }
}
/**
     * put the specified resource in the draft.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function putInDraft($id)
{
  $billet=Billet::find($id);
  if ($billet) {
    return redirect()->route('billets.put-in-draft',compact('billet'));
  }else{
   try {
     DB::transaction(function () use ($id) {
      $archive=Archive::find($id);
      $archive->published=2;
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
  return redirect()->route('billet-archives.index');
}
}
/**
     * put the specified resource in the trash.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function putInTrash($id)
{
 $billet=Billet::find($id);
 if ($billet) {
  return redirect()->route('billets.put-in-trash',compact('billet'));
}else{
 try {
   DB::transaction(function () use ($id) {
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
}
return redirect()->route('billet-archives.index');
}
/**
     * restore the specified resource from the trash.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function restore($id)
{
 $billet=Billet::onlyTrashed()->find($id);
 if ($billet) {
  return redirect()->route('billets.restore',compact('billet'));
}else{
 try {
   DB::transaction(function () use ($id) {
    $archive=Archive::onlyTrashed()->find($id)->restore();
    $revision= new  Revision;
    $revision->type=explode('@', Route::CurrentRouteAction())[1];
    $revision->user_id=Auth::id();
    $revision->billet_id=$id;
    $revision->revised_at=now();
    $revision->save();
  });
   session()->flash('message.type', 'success');
   session()->flash('message.content', 'billet restaurer!');
 } catch (Exception $exc) {
  session()->flash('message.type', 'danger');
  session()->flash('message.content', 'Erreur lors de la restauration!');
//           echo $exc->getTraceAsString();
}
}
return redirect()->route('billet-archives.trash');
}

/**
     * Display a listing of the resource in the trash.
     *
     * @return \Illuminate\Http\Response
     */

public function inTrash(Request $request)
{
 $view='billet.archives.administrator.trash';
 $queryWithPaginate=Archive::onlyTrashed()->with(['getAuthor:id,name','getCategory'])
 ->join('users', 'billet_archives.created_by', '=', 'users.id')
 ->join('billet_categories', 'billet_archives.category_id', '=', 'billet_categories.id')
 ->select('billet_archives.id','billet_archives.title','billet_archives.category_id','billet_archives.published','billet_archives.featured','billet_archives.source_id','billet_archives.created_by','billet_archives.created_at','billet_archives.image','billet_archives.views', 'billet_categories.title as category','users.name as author')
 ->orderBy('billet_archives.id', 'desc')->paginate($this->defaultPageLength);
 $queryWithOutPaginate =Archive::onlyTrashed()->with(['getAuthor:id,name','getCategory'])
 ->join('users', 'billet_archives.created_by', '=', 'users.id')
 ->join('billet_categories', 'billet_archives.category_id', '=', 'billet_categories.id')
 ->select('billet_archives.id','billet_archives.title','billet_archives.category_id','billet_archives.published','billet_archives.featured','billet_archives.source_id','billet_archives.created_by','billet_archives.created_at','billet_archives.image','billet_archives.views', 'billet_categories.title as category','users.name as author');
 $controllerMethodUrl=action('Billet\ArchiveController@inTrash');
 $actions=Archive::trashActions();
 $result=$this->itemsList($request,$queryWithPaginate,$queryWithOutPaginate,$controllerMethodUrl);
 return view($view,$result,$actions);
}
/**
     * Display a listing of the resource in the draft.
     *
     * @return \Illuminate\Http\Response
     */
public function inDraft(Request $request)
{
  $view='billet.archives.administrator.draft';
  $queryWithPaginate=Archive::with(['getAuthor:id,name','getCategory'])
  ->join('users', 'billet_archives.created_by', '=', 'users.id')
  ->join('billet_categories', 'billet_archives.category_id', '=', 'billet_categories.id')
  ->select('billet_archives.id','billet_archives.title','billet_archives.category_id','billet_archives.published','billet_archives.featured','billet_archives.source_id','billet_archives.created_by','billet_archives.created_at','billet_archives.image','billet_archives.views', 'billet_categories.title as category','users.name as author')
  ->where('billet_archives.published',2)
  ->orderBy('billet_archives.id', 'desc')->paginate($this->defaultPageLength);
  $queryWithOutPaginate =Archive::with(['getAuthor:id,name','getCategory'])
  ->join('users', 'billet_archives.created_by', '=', 'users.id')
  ->join('billet_categories', 'billet_archives.category_id', '=', 'billet_categories.id')
  ->select('billet_archives.id','billet_archives.title','billet_archives.category_id','billet_archives.published','billet_archives.featured','billet_archives.source_id','billet_archives.created_by','billet_archives.created_at','billet_archives.image','billet_archives.views', 'billet_categories.title as category','users.name as author')->where('billet_archives.published',2);
  $controllerMethodUrl=action('Billet\ArchiveController@inDraft');
  $actions=Archive::draftActions();
  $result=$this->itemsList($request,$queryWithPaginate,$queryWithOutPaginate,$controllerMethodUrl);
  return view($view,$result,$actions);
}

}
