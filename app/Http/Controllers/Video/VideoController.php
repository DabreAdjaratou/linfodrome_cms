<?php

namespace App\Http\Controllers\Video;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Video\Category;
use App\Models\User\User;
use App\Models\Video\Video;
use App\Models\Video\Archive;
use App\Models\Video\Revision;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class VideoController extends Controller
{
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
     * @return \Illuminate\Http\Response
     */
      public function index(Request $request)
    {
      $view='video.videos.administrator.index';
      $queryWithPaginate=Video::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory','getCameraman:id,name','getEditor:id,name'])->where('published','<>',2)->orderBy('id', 'desc')->paginate(25,['id','title','category_id','published','featured','created_by','cameraman','editor','created_at','start_publication_at','stop_publication_at','views']);
      $queryWithOutPaginate =Video::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory','getCameraman:id,name','getEditor:id,name'])->where('published','<>',2);
      $controllerMethodUrl=action('Video\VideoController@index');
      $actions=Video::indexActions();
      $result=$this->itemsList($request,$queryWithPaginate,$queryWithOutPaginate,$controllerMethodUrl);
      return view($view,$result,$actions);


    }

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

    public function itemsWithTableParameters($items){
      $numberOfItemSFound=$items->count();
      if($numberOfItemSFound==0){
        $tableInfo="Affichage de 0 à ".$numberOfItemSFound." lignes sur ".$items->total();
      }else{
        $tableInfo="Affichage de 1 à ".$numberOfItemSFound." lignes sur ".$items->total();

      }
      $entries=[25,50,100];
      $categories= Category::where('published','<>',2)->get(['id','title']);
      $users= User::get(['id','name']); 
      return compact('items','tableInfo','entries','categories','users');
    }
    
    
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
      case('videos'):
      $items = Video::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory','getCameraman:id,name','getEditor:id,name'])->where('published','<>',2);
      $actions=Video::indexActions();
      break;
      case('video-trash'):
      $items=Video::onlyTrashed()->with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory','getCameraman:id,name','getEditor:id,name']);
      $actions=Video::trashActions();
      break;

      case('video-draft'):
      $items=Video::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory','getCameraman:id,name','getEditor:id,name'])->where('published',2);
      $actions=Video::draftActions();
      break;
    }

    $filterResult=$this->filter($items,$pageLength,$searchByTitle,$searchByCategory,$searchByFeaturedState,$searchByPublishedState,$searchByUser,
     $fromDate,$toDate ,$sortField,$order,$itemType);
    return view('video.videos.administrator.searchAndSort',$filterResult,$actions);

  }

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
      $items = $items->orderBy($sortField, $order)->paginate($pageLength,['id','title','category_id','published','featured','created_by','cameraman','editor','created_at','start_publication_at','stop_publication_at','views']);
    }else{
      $items = $items->orderBy('id', 'desc')->paginate($pageLength,['id','title','category_id','published','featured','created_by','cameraman','editor','created_at','start_publication_at','stop_publication_at','views']);
    }
    if($itemType){
if($itemType=='videos'){ $items->withPath('videos');};
if($itemType=='video-trash'){ $items->withPath('trash');};
if($itemType=='video-draft'){ $items->withPath('draft');};

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
    $entries=[25,50,100];
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
      $categories=Category::where('published',1)->get(['id','title']);
      $users=User::all();
      return view ('video.videos.administrator.create',compact('categories','users'));
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
        'title' => 'required|string',
        'category'=>'required|int',
        'published'=>'nullable',
        'featured'=>'nullable',
        'image'=>'required|image',
        'video'=>'required|string',
        'created_by'=>'int',
        'cameraman'=>'required|int',
        'editor'=>'required|int',
        'start_publication_at'=>'nullable|date_format:d-m-Y H:i:s',
        'stop_publication_at'=>'nullable|date_format:d-m-Y H:i:s',
      ]);

      $video= new Video;
      $video->title =$request->title;
      $video->alias =str_slug($request->title, '-');
      $video->category_id = $request->category;
      $video->published=$request->published ? $request->published : 0 ;
      $video->featured=$request->featured ? $request->featured : 0 ; 
      $video->image = $request->image;
      $video->code = $request->video;
      $video->keywords = $request->tags;
      $video->created_by =$request->created_by;
      $video->cameraman =$request->cameraman;
      $video->editor =$request->editor;
      $video->created_at =now();
       if($request->start_publication_at){
     $start_at=explode(' ',$request->start_publication_at);
     $video->start_publication_at = date("Y-m-d", strtotime($start_at[0])).' '.$start_at[1];
     }else{
      $video->start_publication_at=$request->start_publication_at;
    }
     if($request->start_publication_at){
     $stop_at=explode(' ',$request->stop_publication_at);
     $video->stop_publication_at = date("Y-m-d", strtotime($stop_at[0])).' '.$stop_at[1];
     }else{
      $video->stop_publication_at=$request->stop_publication_at;
     }


      try {
       DB::transaction(function () use ($video) {
         $video->save();
         $lastRecord= Video::latest()->first();
         $archive= new Archive;
         $archive->id = $lastRecord->id;
         $archive->title =$lastRecord->title;
         $archive->alias =$lastRecord->alias;
         $archive->category_id = $lastRecord->category_id;
         $archive->published = $lastRecord->published;
         $archive->featured =$lastRecord->featured;
         $archive->image = $lastRecord->image;
         $archive->code = $lastRecord->code;
         $archive->keywords = $lastRecord->keywords;
         $archive->created_by =$lastRecord->created_by;
         $archive->cameraman =$lastRecord->cameraman;
         $archive->editor =$lastRecord->editor;
         $archive->created_at =$lastRecord->created_at;
         $archive->start_publication_at = $lastRecord->start_publication_at;
         $archive->stop_publication_at =$lastRecord->stop_publication_at;
         $archive->save();
         $oldest = Video::oldest()->first();
         $oldest->delete();
       });

     } catch (Exception $exc) {
      
      session()->flash('message.type', 'danger');
      
      session()->flash('message.content', 'Erreur lors de l\'ajout!');
//           echo $exc->getTraceAsString();
    }
    session()->flash('message.type', 'success');
    session()->flash('message.content', 'Video ajouté avec succès!');

    if ($request->save_close) {
      return redirect()->route('videos.index');
    }else{
      return redirect()->route('videos.create');
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
     $video= Video::with(['getAuthor:id,name','getCategory'])->where('id',$id)->get();
     if (blank($video)) {
      $video= Archive::with(['getAuthor:id,name','getCategory'])->where('id',$id)->get();
    }

    if(blank($video)){
      dd('video not find');
    }

    foreach ($video as $video) {
     $video->views=$video->views + 1 ;
     $video->save();
   }
   return view('video.videos.public.show',compact('video'));

   
 }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $video= Video::find($id);
      $archive=Archive::find($id);
      if(!is_null($video)){
        if($video->checkout==0 || $video->checkout==Auth::id()){
          $video->checkout=Auth::id();
          $archive->checkout=Auth::id();
          $video->save();
          $archive->save();
          $categories=Category::where('published',1)->get(['id','title']);
          $users=user::all('id','name');
          return view('video.videos.administrator.edit',compact('video','categories','users'));
        }elseif ($video->checkout!=0 && $video->checkout!=Auth::id()) {
         session()->flash('message.type', 'warning');
         session()->flash('message.content', 'video dejà en cour de modification!');
         return redirect()->route('videos.index');
       }
     } else{
      return redirect()->route('video-archives.edit',compact('id'));
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
        'title' => 'required|string',
        'category'=>'required|int',
        'published'=>'nullable',
        'featured'=>'nullable',
        'image'=>'image',
        'video'=>'required|string',
        'created_by'=>'int',
        'cameraman'=>'required|int',
        'editor'=>'required|int',
        'start_publication_at'=>'nullable|date_format:d-m-Y H:i:s',
        'stop_publication_at'=>'nullable|date_format:d-m-Y H:i:s',
      ]);
      $video=Video::find($id);
      $video->title =$request->title;
      $video->alias =str_slug($request->title, '-');
      $video->category_id = $request->category;
      $video->published=$request->published ? $request->published : $video->published ;
      $video->featured=$request->featured ? $request->featured : 0 ; 
      $video->image = $request->image ? $request->image : $video->image;
      $video->code = $request->video;
      $video->keywords = $request->tags;
      $video->created_by =$request->created_by;
      $video->cameraman =$request->cameraman;
      $video->editor =$request->editor;
      $video->created_at =now();
       if($request->start_publication_at){
     $start_at=explode(' ',$request->start_publication_at);
     $video->start_publication_at = date("Y-m-d", strtotime($start_at[0])).' '.$start_at[1];
     }else{
      $video->start_publication_at=$request->start_publication_at;
    }
     if($request->start_publication_at){
     $stop_at=explode(' ',$request->stop_publication_at);
     $video->stop_publication_at = date("Y-m-d", strtotime($stop_at[0])).' '.$stop_at[1];
     }else{
      $video->stop_publication_at=$request->stop_publication_at;
     }
      $video->checkout=0;

      try {
       DB::transaction(function () use ($video,$request) {
         $archive=Archive::find($video->id);
         $archive->title =$video->title;
         $archive->alias =$video->alias;
         $archive->category_id = $video->category_id;
         $archive->published = $video->published;
         $archive->featured =$video->featured;
         $archive->image = $video->image;
         $archive->code = $video->code;
         $archive->keywords = $video->tags;
         $archive->created_by =$video->created_by;
         $archive->cameraman =$video->cameraman;
         $archive->editor =$video->editor;
         $archive->created_at =$video->created_at;
         $archive->start_publication_at = $video->start_publication_at;
         $archive->stop_publication_at =$video->stop_publication_at;
         $archive->checkout=0;

         if ($request->update) {
           $video->save();
           $archive->save();
           $revision= new  Revision;
           $revision->type=explode('@', Route::CurrentRouteAction())[1];
           $revision->user_id=Auth::id();
           $revision->video_id=$video->id;
           $revision->revised_at=now();
           $revision->save();
           session()->flash('message.type', 'success');
           session()->flash('message.content', 'Video modifié avec succès!');
           
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
    return redirect()->route('videos.index');

    
  }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
     $revisions= Revision::where('video_id',$id)->get(['id']);
     foreach ($revisions as $r) {
      $r->delete();
    }
    $video=Video::onlyTrashed()->find($id)->forceDelete();
    $archive=Archive::onlyTrashed()->find($id)->forceDelete();
    session()->flash('message.type', 'success');
    session()->flash('message.content', 'Video supprimé avec success!');
    return redirect()->route('videos.trash');
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
        $video=Video::find($id);
        $archive=Archive::find($id);
        $video->published=2;
        $archive->published=2;
        $video->save();
        $archive->save();
        $revision= new  Revision;
        $revision->type=explode('@', Route::CurrentRouteAction())[1];
        $revision->user_id=Auth::id();
        $revision->video_id=$id;
        $revision->revised_at=now();
        $revision->save();
      });
       session()->flash('message.type', 'success');
       session()->flash('message.content', 'Video mis au brouillon!');
     } catch (Exception $exc) {
      session()->flash('message.type', 'danger');
      session()->flash('message.content', 'Erreur lors de la mise au brouillon!');
//           echo $exc->getTraceAsString();
    }
    return redirect()->route('videos.index');
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
    $video=Video::find($id)->delete();
    $archive=Archive::find($id)->delete();
    $revision= new  Revision;
    $revision->type=explode('@', Route::CurrentRouteAction())[1];
    $revision->user_id=Auth::id();
    $revision->video_id=$id;
    $revision->revised_at=now();
    $revision->save();
  });
   session()->flash('message.type', 'success');
   session()->flash('message.content', 'Video mis en corbeille!');
 } catch (Exception $exc) {
  session()->flash('message.type', 'danger');
  session()->flash('message.content', 'Erreur lors de la mise en corbeille!');
//           echo $exc->getTraceAsString();
}
return redirect()->route('videos.index');
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
    $video=Video::onlyTrashed()->find($id)->restore();
    $archive=Archive::onlyTrashed()->find($id)->restore();
    $revision= new  Revision;
    $revision->type=explode('@', Route::CurrentRouteAction())[1];
    $revision->user_id=Auth::id();
    $revision->video_id=$id;
    $revision->revised_at=now();
    $revision->save();
  });
   session()->flash('message.type', 'success');
   session()->flash('message.content', 'Video restaurer!');
 } catch (Exception $exc) {
  session()->flash('message.type', 'danger');
  session()->flash('message.content', 'Erreur lors de la restauration!');
//           echo $exc->getTraceAsString();
}
return redirect()->route('videos.trash');
}
/**
     * Display a listing of the resource in the trash.
     *
     * @return \Illuminate\Http\Response
     */
public function inTrash( Request $request)
{
 $view='video.videos.administrator.trash';
  $queryWithPaginate=Video::onlyTrashed()->with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory','getCameraman:id,name','getEditor:id,name'])->orderBy('id', 'desc')->paginate(25,['id','title','category_id','published','featured','created_by','cameraman','editor','created_at','start_publication_at','stop_publication_at','views']);
        $queryWithOutPaginate =Video::onlyTrashed()->with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory','getCameraman:id,name','getEditor:id,name']);
       $controllerMethodUrl=action('Video\VideoController@inTrash');
  $actions=Video::trashActions();
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
   $view='video.videos.administrator.draft';
  $queryWithPaginate=Video::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory','getCameraman:id,name','getEditor:id,name'])->where('published',2)->orderBy('id', 'desc')->paginate(25,['id','title','category_id','published','featured','created_by','cameraman','editor','created_at','start_publication_at','stop_publication_at','views']);
  $queryWithOutPaginate =Video::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory','getCameraman:id,name','getEditor:id,name'])->where('published',2);
  $controllerMethodUrl=action('Video\VideoController@inDraft');
  $actions=Video::draftActions();
  $result=$this->itemsList($request,$queryWithPaginate,$queryWithOutPaginate,$controllerMethodUrl);
  return view($view,$result,$actions);
}
}
