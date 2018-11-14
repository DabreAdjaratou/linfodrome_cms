<?php

namespace App\Http\Controllers\Article;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article\Article;
use App\Models\Article\Archive;
use App\Models\Article\Source;
use App\Models\Article\Category;
use App\Models\User\User;
use App\Models\Article\Revision;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
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
     @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      $view='article.archives.administrator.index';
      $queryWithPaginate=Archive::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory'])->where('published','<>',2)->orderBy('id', 'desc')->paginate(25,['id','title','category_id','published','featured','source_id','created_by','created_at','image','views']);
      $queryWithOutPaginate =Archive::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory'])->where('published','<>',2);
      $controllerMethodUrl=action('Article\ArchiveController@index');
      $actions=Archive::indexActions();
      $result=$this->articlesList($request,$queryWithPaginate,$queryWithOutPaginate,$controllerMethodUrl);
      return view($view,$result,$actions);


    }
/**
     * get the list of resources.
     @param  \Illuminate\Http\Request  $request, a query with paginate $queryWithPaginate, a query without paginate $queryWithOutPaginate, a controller methode url $controllerMethodUrl
     *
     * @return \Illuminate\Http\Response 
     */
    public function articlesList($request,$queryWithPaginate,$queryWithOutPaginate,$controllerMethodUrl)
    {

      if((url()->full() ==  $controllerMethodUrl || (url()->full() !=  $controllerMethodUrl && !($request->pageLength)))){
        $result=$this->articleWithTableParameters($queryWithPaginate);
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
        $articles = $queryWithOutPaginate;
        $filterResult=$this->filter($articles,$pageLength,$searchByTitle,$searchByCategory,$searchByFeaturedState,$searchByPublishedState,$searchByUser, $fromDate,$toDate,$sortField,$order,$itemType);
        return $filterResult;

      }

    }

    /**
     * get parameters for datatable.
     @param  a query $articles, 
     *
     * @return \Illuminate\Http\Response
     */

    public function articleWithTableParameters($articles){
      $numberOfItemSFound=$articles->count();
      if($numberOfItemSFound==0){
        $tableInfo="Affichage de 0 à ".$numberOfItemSFound." lignes sur ".$articles->total();
      }else{
        $tableInfo="Affichage de 1 à ".$numberOfItemSFound." lignes sur ".$articles->total();

      }
      $entries=[25,50,100];
      $categories= Category::where('published','<>',2)->get(['id','title']);
      $users= User::get(['id','name']); 
      return compact('articles','tableInfo','entries','categories','users');
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
      case('article-archives'):
      $articles = Archive::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory'])->where('published','<>',2);
      $actions=Archive::indexActions();
      break;
      case('article-archive-trash'):
      $articles=Archive::onlyTrashed()->with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory']);
      $actions=Archive::trashActions();
      break;

      case('article-archive-draft'):
      $articles=Archive::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory'])->where('published',2);
      $actions=Archive::draftActions();
      break;
    }

    $filterResult=$this->filter($articles,$pageLength,$searchByTitle,$searchByCategory,$searchByFeaturedState,$searchByPublishedState,$searchByUser,
     $fromDate,$toDate ,$sortField,$order,$itemType);
    return view('article.archives.administrator.searchAndSort',$filterResult,$actions);

  }

  public function filter($articles,$pageLength,$searchByTitle,$searchByCategory,$searchByFeaturedState,$searchByPublishedState,
    $searchByUser,$fromDate,$toDate,$sortField,$order,$itemType) {
    if($searchByTitle){
      $articles =$articles->ofTitle($searchByTitle);
    }
    if($searchByCategory){
      $articles =$articles->ofCategory($searchByCategory);
    }
    
    if(!is_null($searchByFeaturedState)){
      $articles =$articles->ofFeaturedState($searchByFeaturedState);   
    }
    if(!is_null($searchByPublishedState)){
      $articles =$articles->ofPublishedState($searchByPublishedState);   
    }
    if($searchByUser){
      $articles =$articles->ofUser($searchByUser);   
    }
    if($fromDate && !$toDate){ 
      $articles =$articles->ofFromDate($fromDate);   
    }
    if(!$fromDate && $toDate){ 
      $articles =$articles->ofToDate($toDate);
    }
    if($fromDate && $toDate){
      $articles =$articles->ofBetweenTwoDate($fromDate, $toDate);
    }

    if($sortField){
      $articles = $articles->orderBy($sortField, $order)->paginate($pageLength,['id','title','category_id','published','featured','source_id','created_by','created_at','image','views']);
    }else{
      $articles = $articles->orderBy('id', 'desc')->paginate($pageLength,['id','title','category_id','published','featured','source_id','created_by','created_at','image','views']);
    }
    if($itemType){
if($itemType=='article-archives'){ $articles->withPath('article-archives');};
if($itemType=='article-archive-trash'){ $articles->withPath('trash');};
if($itemType=='article-archive-draft'){ $articles->withPath('draft');};

    }

    $articles->appends([
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
    $numberOfItemSFound=$articles->count();
    if($numberOfItemSFound==0){
      $tableInfo="Affichage de 0 à ".$numberOfItemSFound." lignes sur ".$articles->total();
    }else{
      $tableInfo="Affichage de 1 à ".$numberOfItemSFound." lignes sur ".$articles->total();

    }
    $entries=[25,50,100];
    $categories= Category::where('published','<>',2)->get(['id','title']);
    $users= User::get(['id','name']);

    return compact('articles','tableInfo','entries','categories','users','searchByTitle','searchByCategory','searchByFeaturedState','searchByPublishedState','searchByUser','fromDate','toDate');

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

     $article=Article::find($id);
     if ($article) {
      return redirect()->route('articles.edit',compact('article'));
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
          return view('article.archives.administrator.edit',compact('archive','sources','categories','users'));
        }elseif ($archive->checkout!=0 && $archive->checkout!=Auth::id()) {
          session()->flash('message.type', 'warning');
          session()->flash('message.content', 'Article dejà en cour de modification!');
          return redirect()->route('article-archives.index');
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
        'image'=>'image',
        'image_legend'=>'nullable|string',
        'video'=>'nullable|string',
        'gallery_photo'=>'nullable',
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
      $archive->published=$request->published ? $request->published : 0 ;
      $archive->featured=$request->featured ? $request->featured : 0 ; 
      $archive->image = $request->image ? $request->image:$archive->image;
      $archive->image_legend =$request->image_legend;
      $archive->video = $request->video;
      $archive->gallery_photo =$request->gallery_photo;
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

      try {
       DB::transaction(function () use ($archive,$request) {
         if ($request->update) {
           $archive->save();
           $revision= new  Revision;
           $revision->type=explode('@', Route::CurrentRouteAction())[1];
           $revision->user_id=Auth::id();
           $revision->article_id=$archive->id;
           $revision->revised_at=now();
           $revision->save();
           session()->flash('message.type', 'success');
           session()->flash('message.content', 'Article modifié avec succès!');
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

    return redirect()->route('article-archives.index');
  }


/**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function destroy($id)
{

  $revisions= Revision::where('article_id',$id)->get(['id']);
  foreach ($revisions as $r) {
    $r->delete();
  }
  $article=Article::onlyTrashed()->find($id);
  if($article){
    $article=Article::onlyTrashed()->find($id)->forceDelete();
    $archive=Archive::onlyTrashed()->find($id)->forceDelete();
    session()->flash('message.type', 'success');
    session()->flash('message.content', 'Article supprimé avec success!');
    return redirect()->route('article-archives.trash');
  }else{
    $archive=Archive::onlyTrashed()->find($id)->forceDelete();
    session()->flash('message.type', 'success');
    session()->flash('message.content', 'Article supprimé avec success!');
    return redirect()->route('article-archives.trash');
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
  $article=Article::find($id);
  if ($article) {
    return redirect()->route('articles.put-in-draft',compact('article'));
  }else{
    try {
      DB::transaction(function () use ($id) {
        $archive=Archive::find($id);
        $archive->published=2;
        $archive->save();
        $revision= new  Revision;
        $revision->type=explode('@', Route::CurrentRouteAction())[1];
        $revision->user_id=Auth::id();
        $revision->article_id=$id;
        $revision->revised_at=now();
        $revision->save();
      });
      session()->flash('message.type', 'success');
      session()->flash('message.content', 'Article mis au brouillon!');
    } catch (Exception $exc) {
      session()->flash('message.type', 'danger');
      session()->flash('message.content', 'Erreur lors de la mise au brouillon!');
//           echo $exc->getTraceAsString();
    }
    return redirect()->route('article-archives.index');
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
 $article=Article::find($id);
 if ($article) {
  return redirect()->route('articles.put-in-trash',compact('article'));
}else{
 try {
  DB::transaction(function () use ($id) {
    $archive=Archive::find($id)->delete();
    $revision= new  Revision;
    $revision->type=explode('@', Route::CurrentRouteAction())[1];
    $revision->user_id=Auth::id();
    $revision->article_id=$id;
    $revision->revised_at=now();
    $revision->save();
  });
  session()->flash('message.type', 'success');
  session()->flash('message.content', 'Article mis en corbeille!');
} catch (Exception $exc) {
  session()->flash('message.type', 'danger');
  session()->flash('message.content', 'Erreur lors de la mise en corbeille!');
//           echo $exc->getTraceAsString();
}
}
return redirect()->route('article-archives.index');
}

/**
     * restore the specified resource from the trash.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
public function restore($id)
{
 $article=Article::onlyTrashed()->find($id);
 if ($article) {
  return redirect()->route('articles.restore',compact('article'));
}else{
 try {
  DB::transaction(function () use ($id) {
    $archive=Archive::onlyTrashed()->find($id)->restore();
    $revision= new  Revision;
    $revision->type=explode('@', Route::CurrentRouteAction())[1];
    $revision->user_id=Auth::id();
    $revision->article_id=$id;
    $revision->revised_at=now();
    $revision->save();
  });
  session()->flash('message.type', 'success');
  session()->flash('message.content', 'Article restaurer!');
} catch (Exception $exc) {
  session()->flash('message.type', 'danger');
  session()->flash('message.content', 'Erreur lors de la restauration!');
//           echo $exc->getTraceAsString();
}
}
return redirect()->route('article-archives.trash');
}

/**
     * Display a listing of the resource in the trash.
     *
     * @return \Illuminate\Http\Response
     */

public function inTrash( Request $request)
{

  $view='article.archives.administrator.trash';
  $queryWithPaginate=Archive::onlyTrashed()->with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory'])->orderBy('id', 'desc')->paginate(25,['id','title','category_id','published','featured','source_id','created_by','created_at','image','views']);
  $queryWithOutPaginate =Archive::onlyTrashed()->with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory']);
  $controllerMethodUrl=action('Article\ArchiveController@inTrash');
  $actions=Archive::trashActions();
  $result=$this->articlesList($request,$queryWithPaginate,$queryWithOutPaginate,$controllerMethodUrl);
  return view($view,$result,$actions);
}

/**
     * Display a listing of the resource in the draft.
     *
     * @return \Illuminate\Http\Response
     */
public function inDraft(Request $request)
{
   $view='article.archives.administrator.draft';
  $queryWithPaginate=Archive::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory'])->where('published',2)->orderBy('id', 'desc')->paginate(25,['id','title','category_id','published','featured','source_id','created_by','created_at','image','views']);
  $queryWithOutPaginate =Archive::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory'])->where('published',2);
  $controllerMethodUrl=action('Article\ArchiveController@inDraft');
  $actions=Archive::draftActions();
  $result=$this->articlesList($request,$queryWithPaginate,$queryWithOutPaginate,$controllerMethodUrl);
  return view($view,$result,$actions);
}



}
