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

class ArchiveController extends Controller
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
      $view='video.archives.administrator.index';
      $queryWithPaginate=Archive::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory','getCameraman:id,name','getEditor:id,name'])->where('published','<>',2)->orderBy('id', 'desc')->paginate(25,['id','title','category_id','published','featured','created_by','cameraman','editor','created_at','start_publication_at','stop_publication_at','views']);
      $queryWithOutPaginate =Archive::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory','getCameraman:id,name','getEditor:id,name'])->where('published','<>',2);
      $controllerMethodUrl=action('Video\ArchiveController@index');
      $actions=Archive::indexActions();
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
      case('video-archives'):
      $items = Archive::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory','getCameraman:id,name','getEditor:id,name'])->where('published','<>',2);
      $actions=Archive::indexActions();
      break;
      case('video-archive-trash'):
      $items=Archive::onlyTrashed()->with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory','getCameraman:id,name','getEditor:id,name']);
      $actions=Archive::trashActions();
      break;

      case('video-archive-draft'):
      $items=Archive::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory','getCameraman:id,name','getEditor:id,name'])->where('published',2);
      $actions=Archive::draftActions();
      break;
    }

    $filterResult=$this->filter($items,$pageLength,$searchByTitle,$searchByCategory,$searchByFeaturedState,$searchByPublishedState,$searchByUser,
     $fromDate,$toDate ,$sortField,$order,$itemType);
    return view('video.archives.administrator.searchAndSort',$filterResult,$actions);

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
if($itemType=='video-archives'){ $items->withPath('video-archives');};
if($itemType=='video-archive-trash'){ $items->withPath('trash');};
if($itemType=='video-archive-draft'){ $items->withPath('draft');};

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
      $video=Video::find($id);
      if ($video) {
        return redirect()->route('videos.edit',compact('video'));
      }else{
        $video=Archive::find($id);
        if(is_null($video)){
          die('impossible d\'acceder à la resource demander');
        }else{

          if($video->checkout==0 || $video->checkout==Auth::id()){

            $video->checkout=Auth::id();
            $video->save();
            $categories=Category::where('published',1)->get(['id','title']);
            $users=user::all('id','name');
            return view('video.archives.administrator.edit',compact('video','categories','users'));
          }elseif ($video->checkout!=0 || $video->checkout!=Auth::id()) {
            session()->flash('message.type', 'warning');
            session()->flash('message.content', 'video dejà en cour de modification!');
            return redirect()->route('video-archives.index');
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
      $video=Archive::find($id);
      $video->title =$request->title;
      $video->alias =str_slug($request->title, '-');
      $video->category_id = $request->category;
      $video->published=$request->published ? $request->published : $video->published;
      $video->featured=$request->featured ? $request->featured : 0 ; 
      $video->image = $request->image ? $request->image:$video->image;
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
      if ($request->update) {
       $video->save();
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
    return redirect()->route('video-archives.index');
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
    $video=Video::onlyTrashed()->find($id);
    if($video){
      $video=Video::onlyTrashed()->find($id)->forceDelete();
      $archive=Archive::onlyTrashed()->find($id)->forceDelete();
      session()->flash('message.type', 'success');
      session()->flash('message.content', 'Video supprimé avec success!');
      return redirect()->route('video-archives.trash');
    }else{
      $archive=Archive::onlyTrashed()->find($id)->forceDelete();
      session()->flash('message.type', 'success');
      session()->flash('message.content', 'Video supprimé avec success!');
      return redirect()->route('video-archives.trash');
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
  $video=Video::find($id);
  if ($video) {
    return redirect()->route('videos.put-in-draft',compact('video'));
  }else{
   try {
     DB::transaction(function () use ($id) {
      $archive=Archive::find($id);
      $archive->published=2;
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
}
return redirect()->route('video-archives.index');

}
/**
     * put the specified resource in the trash.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function putInTrash($id)
{
 $video=Video::find($id);
 if ($video) {
  return redirect()->route('videos.put-in-trash',compact('video'));
}else{
 try {
   DB::transaction(function () use ($id) {
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
}
return redirect()->route('video-archives.index');
}
/**
     * restore the specified resource from the trash.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

public function restore($id)
{
 $video=Video::onlyTrashed()->find($id);
 if ($video) {
  return redirect()->route('videos.restore',compact('video'));
}else{
 try {
   DB::transaction(function () use ($id) {
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
}
return redirect()->route('video-archives.trash');
}
/**
     * Display a listing of the resource in the trash.
     *
     * @return \Illuminate\Http\Response
     */
public function inTrash( Request $request)
{
 $view='video.archives.administrator.trash';
  $queryWithPaginate=Archive::onlyTrashed()->with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory','getCameraman:id,name','getEditor:id,name'])->orderBy('id', 'desc')->paginate(25,['id','title','category_id','published','featured','created_by','cameraman','editor','created_at','start_publication_at','stop_publication_at','views']);
        $queryWithOutPaginate =Archive::onlyTrashed()->with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory','getCameraman:id,name','getEditor:id,name']);
       $controllerMethodUrl=action('Video\ArchiveController@inTrash');
  $actions=Archive::trashActions();
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
   $view='video.archives.administrator.draft';
  $queryWithPaginate=Archive::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory','getCameraman:id,name','getEditor:id,name'])->where('published',2)->orderBy('id', 'desc')->paginate(25,['id','title','category_id','published','featured','created_by','cameraman','editor','created_at','start_publication_at','stop_publication_at','views']);
  $queryWithOutPaginate =Archive::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory','getCameraman:id,name','getEditor:id,name'])->where('published',2);
  $controllerMethodUrl=action('Video\ArchiveController@inDraft');
  $actions=Archive::draftActions();
  $result=$this->itemsList($request,$queryWithPaginate,$queryWithOutPaginate,$controllerMethodUrl);
  return view($view,$result,$actions);
}

}
