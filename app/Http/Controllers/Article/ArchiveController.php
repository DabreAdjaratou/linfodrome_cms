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
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Archive::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory'])->where('published','<>',2)->get(['id','title','category_id','published','featured','source_id','created_by','created_at','image','views']);
      return view('article.archives.index',['articles'=>$articles]);
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
        if($article){
       return redirect()->route('articles.edit',['article'=>$article]);
        }else{
      $archive=Archive::find($id);
      if($archive->checkout!=0){
        if ($archive->checkout!=Auth::id()) {
         session()->flash('message.type', 'warning');
         session()->flash('message.content', 'Article dejà en cour de modification!');
         return redirect()->route('articles.index');
       }else{
        $sources=Source::all('id','title');
        $categories=Category::all('id','title');
        $users=user::all('id','name');
        return view('article.archives.edit',compact('archive','sources','categories','users'));
      }
    }else{
      $archive->checkout=Auth::id();
      $archive->save();
      $sources=Source::all('id','title');
      $categories=Category::all('id','title');
      $users=user::all('id','name');
      return view('article.archives.edit',compact('archive','sources','categories','users'));
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
     $archive->published=$request->published ? $request->published : 0 ;
     $archive->featured=$request->featured ? $request->featured : 0 ; 
     $archive->image = $request->image ? $request->image:$archive->image;
     $archive->image_legend =$request->image_legend;
     $archive->video = $request->video;
     $archive->gallery_photo =$request->gallery_photo;
     $archive->introtext = $request->introtext;
     $archive->fulltext =$request->fulltext;
     $archive->source_id = $request->source;
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
        $article=Article::onlyTrashed()->find($id);
        if($article){
            return redirect()->route('articles.destroy',compact('article'));
        }else{
    $archive=Archive::onlyTrashed()->find($id)->forceDelete();
    session()->flash('message.type', 'success');
    session()->flash('message.content', 'Article supprimé avec success!');
    return redirect()->route('article-archives.index');
    }
    }

     public function putInDraft($id)
    {
      $article=Article::find($id);
      if ($article) {
        return redirect()->route('articles.put-in-draft',compact('article'));
      }else{
      $archive=Archive::find($id);
      $archive->published=2;
      $archive->save();
     session()->flash('message.type', 'success');
     session()->flash('message.content', 'Article mis au brouillon!');
    return back();
    }
}

    public function putInTrash($id)
    {
       $article=Article::find($id);
      if ($article) {
        return redirect()->route('articles.put-in-trash',compact('article'));
      }else{
    $archive=Archive::find($id)->delete();
    session()->flash('message.type', 'success');
    session()->flash('message.content', 'Article mis en corbeille!');
}
    return back();

    }

    public function restore($id)
    {
         $article=Article::find($id);
      if ($article) {
        return redirect()->route('articles.restore',compact('article'));
      }else{
      $archive=Archive::onlyTrashed()->find($id)->restore();
      session()->flash('message.type', 'success');
      session()->flash('message.content', 'Article restaurer!');
  }
      return redirect()->route('article-archives.index');
    }

    public function inTrash()
    {
       $archives=Archive::onlyTrashed()->with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory'])->get(['id','title','category_id','published','featured','source_id','created_by','created_at','image','views']);
       return view('article.archives.trash',compact('archives'));
    }

public function inDraft()
    {
      $archives=Archive::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory'])->where('published',2)->get(['id','title','category_id','published','featured','source_id','created_by','created_at','image','views']);
        return view('article.archives.draft',compact('archives'));
  }

/**
     * Display a listing of the revision.
     *
     * @return \Illuminate\Http\Response
     */
  public function revision()

  {
    $articles= Archive::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory'])->get(['id','title','category_id','created_by','created_at']);
    return view('article.archives.revision',['articles'=>$articles]);
  }
}
