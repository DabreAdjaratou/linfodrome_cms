<?php

namespace App\Http\Controllers\Article;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article\Revision;
use App\Models\Article\Archive;

class RevisionController extends Controller
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
       $revisions=Revision::with(['getModifier:id,name','getArticle:id,title,category_id,created_by,created_at','getArticle.getCategory:id,title',
          'getArticle.getAuthor:id,name'])->get()->groupBy('article_id');
       return view('article.revisions.administrator.index',compact('revisions'));
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
     * @param  int  $articleId
     * @return \Illuminate\Http\Response
     */
    public function show($articleId)
    {
     $article=Archive::with(['getRevision.getModifier:id,name','getCategory:id,title',
      'getAuthor:id,name'])->withTrashed()->where('id',$articleId)->get();
     return view('article.revisions.administrator.show',compact('article'));
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
