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
use Illuminate\Support\Facades\Storage;
use Image;

class ArticleController extends Controller
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
      $view='article.articles.administrator.index';
      $queryWithPaginate=Article::with(['getAuthor:id,name','getCategory'])->where('published','<>',2)->orderBy('published', 'asc')->paginate($this->defaultPageLength,['id','title','category_id','published','featured','source_id','created_by','created_at','image','views']);
      $queryWithOutPaginate = Article::with(['getAuthor:id,name','getCategory'])
      ->join('users', 'articles.created_by', '=', 'users.id')
      ->join('article_categories', 'articles.category_id', '=', 'article_categories.id')
      ->where('articles.published','<>',2);
      
      $controllerMethodUrl=action('Article\ArticleController@index');
      $actions= Article::indexActions();
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
        $articles = $queryWithOutPaginate;
        $filterResult=$this->filter($articles,$pageLength,$searchByTitle,$searchByCategory,$searchByFeaturedState,$searchByPublishedState,$searchByUser, $fromDate,$toDate,$sortField,$order,$itemType);
        return $filterResult;

      }

    }
 /**
     * get parameters for datatable.
     * @param  items collection $articles, 
     *
     * @return items collection  $article, datatable information $tableInfo, datatable entries $entries, items categories $categoies, users $users 
     **/
 public function itemsWithTableParameters($articles){
  $numberOfItemSFound=$articles->count();
  if($numberOfItemSFound==0){
    $tableInfo="Affichage de 0 à ".$numberOfItemSFound." lignes sur ".$articles->total();
  }else{
    $tableInfo="Affichage de 1 à ".$numberOfItemSFound." lignes sur ".$articles->total();

  }
  $entries=$this->entries;
  $categories= Category::where('published','<>',2)->get(['id','title']);
  $users= User::get(['id','name']); 
  return compact('articles','tableInfo','entries','categories','users');
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
      case('articles'):
      $articles = Article::with(['getAuthor:id,name','getCategory'])
      ->join('users', 'articles.created_by', '=', 'users.id')
      ->join('article_categories', 'articles.category_id', '=', 'article_categories.id')
      ->where('articles.published','<>',2);

      $actions=Article::indexActions();
      break;
      case('article-trash'):
      $articles=Article::onlyTrashed()->with(['getAuthor:id,name','getCategory'])
      ->join('users', 'articles.created_by', '=', 'users.id')
      ->join('article_categories', 'articles.category_id', '=', 'article_categories.id');

      $actions=Article::trashActions();
      break;

      case('article-draft'):
      $articles=Article::with(['getAuthor:id,name','getCategory'])
      ->join('users', 'articles.created_by', '=', 'users.id')
      ->join('article_categories', 'articles.category_id', '=', 'article_categories.id')
      ->where('articles.published',2);
      $actions=Article::draftActions();
      break;
    }

    $filterResult=$this->filter($articles,$pageLength,$searchByTitle,$searchByCategory,$searchByFeaturedState,$searchByPublishedState,$searchByUser,
     $fromDate,$toDate ,$sortField,$order,$itemType);
    return view('article.articles.administrator.searchAndSort',$filterResult,$actions);

  }

/**
*filter datatable
*@param items collection $article, number of items par page $pageLength, value of search fields: $searchByTitle, $searchByCategory, $searchByFeaturedState , $searchByPublishedState, $searchByUser, $fromDate, $toDate, $sortField, $order, itemType
*
*@return tems collection $article, number of items par page $pageLength, value of search fields: $searchByTitle, $searchByCategory, $searchByFeaturedState , $searchByPublishedState, $searchByUser, $fromDate, $toDate, $sortField, $order, itemType
**/
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
    $articles = $articles->orderBy($sortField, $order)->select('articles.id','articles.title','articles.category_id','articles.published','articles.featured','articles.source_id','articles.created_by','articles.created_at','articles.image','articles.views', 'article_categories.title as category','users.name as author')->paginate($pageLength);
  }else{
    $articles = $articles->orderBy('published', 'asc')->select('articles.id','articles.title','articles.category_id','articles.published','articles.featured','articles.source_id','articles.created_by','articles.created_at','articles.image','articles.views', 'article_categories.title as category','users.name as author')->paginate($pageLength);
  }
  if($itemType){

    if($itemType=='articles'){ $articles->withPath('articles');};
    if($itemType=='article-trash'){ $articles->withPath('trash');};
    if($itemType=='article-draft'){ $articles->withPath('draft');};


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
  $entries=$this->entries;
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
          $sources=Source::where('published',1)->get(['id','title']);
          $categories=Category::where('published',1)->get(['id','title']);
          $users=user::all('id','name');
          return view('article.articles.administrator.create',compact('sources','categories','users'));
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
      'image'=>'required|image',
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

     $article= new Article;
     $article->ontitle = $request->ontitle;
     $article->title =$request->title;
     $article->alias =str_slug($request->title, '-');
     $article->category_id = $request->category;
     $article->published=$request->published ? $request->published : 0 ;
     $article->featured=$request->featured ? $request->featured : 0 ;
     $article->image_legend =$request->image_legend;
     $article->video = $request->video;
     $article->gallery_photo =$request->gallery_photo;
     $article->introtext = $request->introtext;
     $article->fulltext =$request->fulltext;
     $article->source_id = $request->source;
     $article->keywords=$request->tags;
     $article->created_by =$request->created_by ?? $request->auth_userid;
     $article->created_at =now();
     if($request->start_publication_at){
       $start_at=explode(' ',$request->start_publication_at);
       $article->start_publication_at = date("Y-m-d", strtotime($start_at[0])).' '.$start_at[1];
     }else{
      $article->start_publication_at=$request->start_publication_at;
    }
    if($request->start_publication_at){
     $stop_at=explode(' ',$request->stop_publication_at);
     $article->stop_publication_at = date("Y-m-d", strtotime($stop_at[0])).' '.$stop_at[1];
   }else{
    $article->stop_publication_at=$request->stop_publication_at;
  }
  
  $article->checkout=0;
        // Storage::disk('local')->put('Images',$request->image->getClientOriginalName());
  try {
   DB::transaction(function () use ($article,$request) {
     $article->save();
     $imageExtension= '.'.$request->image->extension();
     if($imageExtension=='.jpeg'){
      $imageExtension='.jpg';
    }
    $filenameWithOutExtension=str_slug(basename(strtolower($request->image->getClientOriginalName()) , $imageExtension),'-');
    $filename=$filenameWithOutExtension.'-'.$article->id.$imageExtension;
    $article->image=$filename;
    $request->image->storeAs('public/images/articles/sources', $filename);
    $article->save();
    $lastRecord= Article::latest()->first();
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
    $archive->video = $lastRecord->video;
    $archive->gallery_photo =$lastRecord->gallery_photo;
    $archive->introtext = $lastRecord->introtext;
    $archive->fulltext =$lastRecord->fulltext;
    $archive->source_id = $lastRecord->source_id;
    $archive->created_by =$lastRecord->created_by;
    $archive->created_at =$lastRecord->created_at;
    $archive->start_publication_at = $lastRecord->start_publication_at;
    $archive->stop_publication_at =$lastRecord->stop_publication_at;
    $archive->checkout=0;
    $archive->save();

    $oldest = Article::oldest()->first();
    $oldest->delete();

    $this->resizedImages($article->id,$filename,$filenameWithOutExtension,$imageExtension);
  });

 } catch (Exception $exc) {
  session()->flash('message.type', 'danger');
  session()->flash('message.content', 'Erreur lors de l\'ajout!');
//           echo $exc->getTraceAsString();
}

session()->flash('message.type', 'success');
session()->flash('message.content', 'Article ajouté avec succès!');

if ($request->save_close) {
 return redirect()->route('articles.index');

}else{
  return redirect()->route('articles.create');
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
     $article= Article::with(['getAuthor:id,name','getCategory'])->where('id',$id)->get();
     if (blank($article)) {
      $article= Archive::with(['getAuthor:id,name','getCategory'])->where('id',$id)->get();
    }

    if(blank($article)){
      return 'article not find';
    }

    foreach ($article as $article) {
     $article->views=$article->views + 1 ;
     $article->save();
   }
   return view('article.articles.public.show',compact('article'));

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
      $archive=Archive::find($id);
      if(!is_null($article)){
        if($article->checkout==0 || $article->checkout==Auth::id()){
          $article->checkout=Auth::id();
          $archive->checkout=Auth::id();
          $article->save();
          $archive->save();
          $sources=Source::where('published',1)->get(['id','title']);
          $categories=Category::where('published',1)->get(['id','title']);
          $users=user::all('id','name');
          return view('article.articles.administrator.edit',compact('article','sources','categories','users'));
        }elseif ($article->checkout!=0 && $article->checkout!=Auth::id()) {
         session()->flash('message.type', 'warning');
         session()->flash('message.content', 'Article dejà en cour de modification!');
         return redirect()->route('articles.index');
       }
     } else{
      return redirect()->route('article-archives.edit',compact('id'));
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
      
      $article=Article::find($id);
      if (is_null($article)) {
       $article=Archive::find($id);
     }
     $article->ontitle = $request->ontitle;
     $article->title =$request->title;
     $article->alias =str_slug($request->title, '-');
     $article->category_id = $request->category;
     $article->published=$request->published ? $request->published : 0;
     $article->featured=$request->featured ? $request->featured : 0 ; 
     $article->image = $request->image ? $request->image->storeAs('public/images/articles/thumbs/original', $request->image->getClientOriginalName()):$article->image;
     $article->image_legend =$request->image_legend;
     $article->video = $request->video;
     $article->gallery_photo =$request->gallery_photo;
     $article->introtext = $request->introtext;
     $article->fulltext =$request->fulltext;
     $article->source_id = $request->source;
     $article->keywords = $request->tags;
     $article->created_by =$request->created_by ?? $request->auth_userid;
     $article->created_at =now();
     if($request->start_publication_at){
       $start_at=explode(' ',$request->start_publication_at);
       $article->start_publication_at = date("Y-m-d", strtotime($start_at[0])).' '.$start_at[1];
     }else{
      $article->start_publication_at=$request->start_publication_at;
    }
    if($request->start_publication_at){
     $stop_at=explode(' ',$request->stop_publication_at);
     $article->stop_publication_at = date("Y-m-d", strtotime($stop_at[0])).' '.$stop_at[1];
   }else{
    $article->stop_publication_at=$request->stop_publication_at;
  }
  
  $article->checkout=0;

  try {
   DB::transaction(function () use ($article,$request) {
     $archive= Archive::find($article->id);
     $archive->ontitle = $article->ontitle;
     $archive->title =$article->title;
     $archive->alias =$article->alias;
     $archive->category_id = $article->category_id;
     $archive->published = $article->published;
     $archive->featured =$article->featured;
     $archive->image = $article->image;
     $archive->image_legend =$article->image_legend;
     $archive->video = $article->video;
     $archive->gallery_photo =$article->gallery_photo;
     $archive->introtext = $article->introtext;
     $archive->fulltext =$article->fulltext;
     $archive->source_id = $article->source_id;
     $archive->keywords = $article->keywords;
     $archive->created_by =$article->created_by;
     $archive->created_at =$article->created_at;
     $archive->start_publication_at = $article->start_publication_at;
     $archive->stop_publication_at =$article->stop_publication_at;
     $archive->checkout=0;
     if ($request->update) {
       $article->save();
       $archive->save();
       $revision= new  Revision;
       $revision->type=explode('@', Route::CurrentRouteAction())[1];
       $revision->user_id=Auth::id();
       $revision->article_id=$article->id;
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
return redirect()->route('articles.index');

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
      $article=Article::onlyTrashed()->find($id)->forceDelete();
      $archive=Archive::onlyTrashed()->find($id)->forceDelete();
      session()->flash('message.type', 'success');
      session()->flash('message.content', 'Article supprimé avec success!');
      return redirect()->route('articles.trash');
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
        $article=Article::find($id);
        $archive=Archive::find($id);
        $article->published=2;
        $archive->published=2;
        $article->save();
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
    return redirect()->route('articles.index');
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
    $article=Article::find($id)->delete();
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

return redirect()->route('articles.index');
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
    $article=Article::onlyTrashed()->find($id)->restore();
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
return redirect()->route('articles.trash');
}


/**
     * Display a listing of the resource in the trash.
     *
     * @return \Illuminate\Http\Response
     */

public function inTrash(Request $request)
{
  $view='article.articles.administrator.trash';
  $queryWithPaginate=Article::onlyTrashed()->with(['getAuthor:id,name','getCategory'])
  ->join('users', 'articles.created_by', '=', 'users.id')
  ->join('article_categories', 'articles.category_id', '=', 'article_categories.id')
  ->select('articles.id','articles.title','articles.category_id','articles.published','articles.featured','articles.source_id','articles.created_by','articles.created_at','articles.image','articles.views', 'article_categories.title as category','users.name as author')
  ->orderBy('articles.id', 'desc')->paginate($this->defaultPageLength);
  $queryWithOutPaginate =Article::onlyTrashed()->with(['getAuthor:id,name','getCategory'])
  ->join('users', 'articles.created_by', '=', 'users.id')
  ->join('article_categories', 'articles.category_id', '=', 'article_categories.id')
  ->select('articles.id','articles.title','articles.category_id','articles.published','articles.featured','articles.source_id','articles.created_by','articles.created_at','articles.image','articles.views', 'article_categories.title as category','users.name as author');
  $controllerMethodUrl=action('Article\ArticleController@inTrash');
  $actions=Article::trashActions();
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

 $view='article.articles.administrator.draft';
 $queryWithPaginate=Article::with(['getAuthor:id,name','getCategory'])
 ->join('users', 'articles.created_by', '=', 'users.id')
 ->join('article_categories', 'articles.category_id', '=', 'article_categories.id')
 ->select('articles.id','articles.title','articles.category_id','articles.published','articles.featured','articles.source_id','articles.created_by','articles.created_at','articles.image','articles.views', 'article_categories.title as category','users.name as author')
 ->where('articles.published',2)
 ->orderBy('articles.id', 'desc')->paginate($this->defaultPageLength);
 $queryWithOutPaginate =Article::with(['getAuthor:id,name','getCategory'])
 ->join('users', 'articles.created_by', '=', 'users.id')
 ->join('article_categories', 'articles.category_id', '=', 'article_categories.id')
 ->select('articles.id','articles.title','articles.category_id','articles.published','articles.featured','articles.source_id','articles.created_by','articles.created_at','articles.image','articles.views', 'article_categories.title as category','users.name as author')->where('articles.published',2);
 $controllerMethodUrl=action('Article\ArticleController@inDraft');
 $actions=Article::draftActions();
 $result=$this->itemsList($request,$queryWithPaginate,$queryWithOutPaginate,$controllerMethodUrl);
 return view($view,$result,$actions);
}

/**
* resize and store an image 
*@param item id $article_id, the filename $filename, the filename whithout extension, the file extension
*@return
**/
public function resizedImages($article_id,$filename ,$filenameWithOutExtension,$imageExtension)
{
  define('WEBSERVICE', 'http://api.resmush.it/ws.php?img=');
// $s=asset('storage/images/articles/sources'.$filename);
  $s='http://www.linfodrome.com/media/k2/items/cache/0df43a25328451d5e0cb75a88ba00fd6_L.jpg';
  $o = json_decode(file_get_contents(WEBSERVICE . $s));
  if(!isset($o->error)){
    $image=file_get_contents($o->dest);
    Storage::put('public/images/articles/sources/'.$filename, $image);
  }
  $imgS = Image::make(storage_path('app/public/images/articles/sources/'.$filename))->resize(65,65);
  $imgM = Image::make(storage_path('app/public/images/articles/sources/'.$filename))->resize(80,80);
  $imgL = Image::make(storage_path('app/public/images/articles/sources/'.$filename))->resize(85,85);
  $imgXL = Image::make(storage_path('app/public/images/articles/sources/'.$filename))->resize(400,210);
  $imgS->save(storage_path('app/public/images/articles/thumbs/'.$filenameWithOutExtension.'-'.$article_id.'-65X65'.$imageExtension));
  $imgM->save(storage_path('app/public/images/articles/thumbs/'.$filenameWithOutExtension.'-'.$article_id.'-80X80'.$imageExtension));
  $imgL->save(storage_path('app/public/images/articles/thumbs/'.$filenameWithOutExtension.'-'.$article_id.'-85X85'.$imageExtension));
  $imgXL->save(storage_path('app/public/images/articles/thumbs/'.$filenameWithOutExtension.'-'.$article_id.'-400X210'.$imageExtension));

}
}