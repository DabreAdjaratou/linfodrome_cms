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
use Freshbitsweb\Laratables\Laratables;
use Yajra\Datatables\Datatables;

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
    // public function index()
    // {
    //   // $articles = Archive::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory'])->orderBy('id', 'desc')->get(['id','title','category_id','published','featured','source_id','created_by','created_at','image','views']);
    //   $articles = Archive::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory'])->orderBy('id', 'desc')->paginate(100);
        
    //   return view('article.archives.administrator.index',compact('articles','allArticles'));
    // }

    public function index()
    {
$articles = Archive::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory'])->orderBy('id', 'desc')->paginate(25);
           return view('article.archives.administrator.index',compact('articles'));
    }

    
    /**
    *fetch data for laratable
    *
    * @return json response
    */
     public function laratableData()
    {
      $articles = Archive::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory'])->orderBy('id', 'desc')->get(['id','title','category_id','published','featured','source_id','created_by','created_at','image','views']);
       return Datatables::of($articles)->make();
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
        'start_publication_at'=>'nullable|date_format:Y-m-d H:i:s',
        'stop_publication_at'=>'nullable|date_format:Y-m-d H:i:s',

      ]);
      $archive=Archive::find($id);
      $archive->ontitle = $request->ontitle;
      $archive->title =$request->title;
      $archive->alias =str_slug($request->title, '-');
      $archive->category_id = $request->category;
      $archive->published=$request->published ? $request->published : $archive->published ;
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
      $archive->start_publication_at = $request->start_publication_at;
      $archive->stop_publication_at =$request->stop_publication_at;
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
 $article=Article::find($id);
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

public function inTrash()
{
 $archives=Archive::onlyTrashed()->with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory'])->orderBy('id', 'desc')->get(['id','title','category_id','published','featured','source_id','created_by','created_at','image','views']);
 return view('article.archives.administrator.trash',compact('archives'));
}

/**
     * Display a listing of the resource in the draft.
     *
     * @return \Illuminate\Http\Response
     */
public function inDraft()
{
  $archives=Archive::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory'])->where('published',2)->orderBy('id', 'desc')->get(['id','title','category_id','published','featured','source_id','created_by','created_at','image','views']);
  return view('article.archives.administrator.draft',compact('archives'));
}


}
