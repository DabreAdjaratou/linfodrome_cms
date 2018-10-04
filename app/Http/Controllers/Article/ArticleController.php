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
    public function index()
    {   
      $articles = Article::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory'])->get(['id','title','category_id','published','featured','source_id','created_by','created_at','image','views']);

      return view('article.articles.administrator.index',['articles'=>$articles]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()

    {
      // session()->put('link',url()->previous());
      // mkdir(storage_path("/path/to/my/dir"),0777,true);
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
      'start_publication_at'=>'nullable|date_format:Y-m-d H:i:s',
      'stop_publication_at'=>'nullable|date_format:Y-m-d H:i:s',

    ]);

     $article= new Article;
     $article->ontitle = $request->ontitle;
     $article->title =$request->title;
     $article->alias =str_slug($request->title, '-');
     $article->category_id = $request->category;
     $article->published=$request->published ? $request->published : 0 ;
     $article->featured=$request->featured ? $request->featured : 0 ;
     $article->image = $request->image->storeAs('images/articles/thumbs/original', $request->image->getClientOriginalName()); 
     $img1 = Image::make(storage_path('app/images/articles/thumbs/original/'.$request->image->getClientOriginalName()))->resize(300, 420);
     $img2 = Image::make(storage_path('app/images/articles/thumbs/original/'.$request->image->getClientOriginalName()))->resize(250, 180);
     $img3 = Image::make(storage_path('app/images/articles/thumbs/original/'.$request->image->getClientOriginalName()))->resize(180, 180);
     $img1->save(storage_path('app/images/articles/thumbs/resized/'.$request->image->getClientOriginalName()));
     $img2->save(storage_path('app/images/articles/thumbs/resized/'.$request->image->getClientOriginalName()));
     $img3->save(storage_path('app/images/articles/thumbs/resized/'.$request->image->getClientOriginalName()));
     // $article->image = $request->image->getClientOriginalName();
     $article->image_legend =$request->image_legend;
     $article->video = $request->video;
     $article->gallery_photo =$request->gallery_photo;
     $article->introtext = $request->introtext;
     $article->fulltext =$request->fulltext;
     $article->source_id = $request->source;
     $article->created_by =$request->created_by ?? $request->auth_userid;
     $article->created_at =now();
     $article->start_publication_at = $request->start_publication_at;
     $article->stop_publication_at =$request->stop_publication_at;
     $article->checkout=0;

        // Storage::disk('local')->put('Images',$request->image->getClientOriginalName());
     try {
       DB::transaction(function () use ($article) {
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

       // $oldest = Article::oldest()->first();
       // $oldest->delete();
       });

     } catch (Exception $exc) {
      session()->flash('message.type', 'danger');
      session()->flash('message.content', 'Erreur lors de l\'ajout!');
//           echo $exc->getTraceAsString();
    }

    session()->flash('message.type', 'success');
    session()->flash('message.content', 'Article ajouté avec succès!');
    
    if ($request->save_close) {
     // return back()->withInput();
     // return redirect(session()->get('link'));
    return redirect()->route('article-archives.index');

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
    $article= Article::find($id);
    $archive=Archive::find($id);
    if($article->checkout!=0){
      if ($article->checkout!=Auth::id()) {
       session()->flash('message.type', 'warning');
       session()->flash('message.content', 'Article dejà en cour de modification!');
       return redirect()->route('article-archives.index');
     }else{
      $sources=Source::where('published',1)->get(['id','title']);
      $categories=Category::where('published',1)->get(['id','title']);
      $users=user::all('id','name');
      return view('article.articles.administrator.edit',compact('article','sources','categories','users'));
    }
  }else{
    $article->checkout=Auth::id();
    $archive->checkout=Auth::id();
    $archive->save();
    $article->save();
    $sources=Source::where('published',1)->get(['id','title']);
    $categories=Category::where('published',1)->get(['id','title']);
    $users=user::all('id','name');
    return view('article.articles.administrator.edit',compact('article','sources','categories','users'));
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
        'start_publication_at'=>'nullable|date_format:Y-m-d H:i:s',
        'stop_publication_at'=>'nullable|date_format:Y-m-d H:i:s',

      ]);
      
      $article=Article::find($id);
      if (is_null($article)) {
       $article=Archive::find($id);
     }
     $article->ontitle = $request->ontitle;
     $article->title =$request->title;
     $article->alias =str_slug($request->title, '-');
     $article->category_id = $request->category;
     $article->published=$request->published ? $request->published : $article->published ;
     $article->featured=$request->featured ? $request->featured : 0 ; 
     $article->image = $request->image ? $request->image->storeAs('images/articles/thumbs/original', $request->image->getClientOriginalName()):$article->image;
     $article->image_legend =$request->image_legend;
     $article->video = $request->video;
     $article->gallery_photo =$request->gallery_photo;
     $article->introtext = $request->introtext;
     $article->fulltext =$request->fulltext;
     $article->source_id = $request->source;
     $article->created_by =$request->created_by ?? $request->auth_userid;
     $article->created_at =now();
     $article->start_publication_at = $request->start_publication_at;
     $article->stop_publication_at =$request->stop_publication_at;
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
      $article=Article::onlyTrashed()->find($id)->forceDelete();
      $archive=Archive::onlyTrashed()->find($id)->forceDelete();
      session()->flash('message.type', 'success');
      session()->flash('message.content', 'Article supprimé avec success!');
      return redirect()->route('article-archives.trash');
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
    return redirect()->route('article-archives.index');
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
return redirect()->route('article-archives.trash');
}


/**
     * Display a listing of the resource in the trash.
     *
     * @return \Illuminate\Http\Response
     */

public function inTrash()
{
 $articles=Article::onlyTrashed()->with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory'])->get(['id','title','category_id','published','featured','source_id','created_by','created_at','image','views']);
 return view('article.articles.administrator.trash',compact('articles'));
}

/**
     * Display a listing of the resource in the draft.
     *
     * @return \Illuminate\Http\Response
     */

public function inDraft()
{
  $articles=Article::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory'])->where('published',2)->get(['id','title','category_id','published','featured','source_id','created_by','created_at','image','views']);
  return view('article.articles.administrator.draft',compact('articles'));
}
}