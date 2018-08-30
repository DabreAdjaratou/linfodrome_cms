<?php

namespace App\Http\Controllers\Article;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article\Article;
use App\Models\Article\Source;
use App\Models\User\User;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()

    {
        
        $sources=Source::all();
        $users=user::all('id','name');
        $auth_username = Auth::user()->name;
        return view('article.articles.create',['sources'=>$sources,'auth_username'=>$auth_username, 'users'=>$users]);

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
        'published'=>'nullable',
        'featured'=>'nullable',
        'image'=>'required|image',
        'image_legend'=>'nullable|string',
        'video'=>'nullable|string',
        'gallery_photo'=>'nullable',
        'intro_text'=>'nullable|string',
        'full_text'=>'required|string',
        'source'=>'required|int',
        'created_by'=>'required|int',
        'start_publication_at'=>'nullable|string',
        'stop_publication_at'=>'nullable|int',

    ]);

       $article= new article;
       $article->ontitle = $request->ontitle;
       $article->title =$request->title;
       if(isset($request->published)){
        $article->published = 1;
       }else{

        $article->published = 0;
       }

       if (isset($request->featured)) {
          $article->featured =1;
       }else {
           $article->featured =0;
       }
       $article->image = $request->image;
       $article->image_legend =$request->image_legend;
       $article->video = $request->video;
       $article->gallery_photo =$request->gallery_photo;
       $article->intro_text = $request->intro_text;
       $article->full_text =$request->full_text;
       $article->source = $request->source;
       $article->created_by =$request->created_by;
       $article->start_publication_at = $request->start_publication_at;
       $article->stop_publication_at =$request->stop_publication_at;
              if ($article->save()) {
        $request->session()->flash('message.type', 'success');
        $request->session()->flash('message.content', 'Article ajouté avec succès!');
    } else {
        $request->session()->flash('message.type', 'danger');
        $request->session()->flash('message.content', 'Erreur lors de l\'ajout!');
    }
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
