<?php

namespace App\Http\Controllers\Article;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article\Article;
use App\Models\Article\Archive;
use App\Models\Article\Source;
use App\Models\Article\Category;
use App\Models\User\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Protecting routes
     */
    public function __construct()
{
    $this->middleware('auth');
}
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $articles = Article::with(['getRevision.getModifier:id,name','getAuthor:id,name','getCategory'])->get(['id','title','category_id','published','featured','source_id','created_by','created_at','image','views']);
        return view('article.archives.index',['articles'=>$articles]);
             
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()

    {
        
        $sources=Source::all();
        $categories=Category::all();
        $users=user::all('id','name');
        return view('article.articles.create',['sources'=>$sources, 'categories'=>$categories,'users'=>$users]);

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
       $article->image = $request->image;
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
       $archive->save();
     
       $oldest = Article::oldest()->first();
       $oldest->delete();
});
           
       } catch (Exception $exc) {
        session()->flash('message.type', 'danger');
        session()->flash('message.content', 'Erreur lors de l\'ajout!');
//           echo $exc->getTraceAsString();
       }

       session()->flash('message.type', 'success');
       session()->flash('message.content', 'Article ajouté avec succès!');
    
       if ($request->save_close) {
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

}
