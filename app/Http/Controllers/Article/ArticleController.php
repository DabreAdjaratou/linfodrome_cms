<?php

namespace App\Http\Controllers\Article;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article\Article;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $articles = Article::all('id','title','category_id','published','featured','source_id','created_by','created_at','image','views');

        $articles = Article::with('getRevision','getAutor:id,name')->get(['id','title','category_id','published','featured','source_id','created_by','created_at','image','views']);
        foreach ($articles as $a) {
         if ($a->published==1) {
          $a->published=' <span class="uk-border-circle uk-text-success uk-text-bold uk-margin-small-left icon-container">✔</span>';
      } else {
        $a->published='<span class="uk-border-circle uk-text-danger uk-text-bold uk-margin-small-left icon-container">✖</span>';

    }

    if ($a->featured==1) {
          $a->featured=' <span class="uk-border-circle uk-text-success uk-text-bold uk-margin-small-left icon-container">✔</span>';
      } else {
        $a->featured='<span class="uk-border-circle uk-text-danger uk-text-bold uk-margin-small-left icon-container">✖</span>';
        
    }
}

  //       foreach ($articles as $a) {

  //      for ($i=0; $i <count($a->getRevision) ; $i++) { 
  //       if($i==count($a->getRevision)-1){
  //           $revised_at=$a->getRevision[$i]->revised_at;
  //           echo $revised_at;
  //       }
  // $articles=('revised_at', $revised_at);           
  //             } 
  //         }

// print_r($articles);
return view('article.articles.index',['articles'=>$articles]);
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return ('article.articles.create');
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
