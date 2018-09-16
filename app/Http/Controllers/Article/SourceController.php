<?php

namespace App\Http\Controllers\Article;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Article\Source;

class SourceController extends Controller
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
        $sources=Source::all();
        return view ('article.sources.index',['sources'=>$sources]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('article.sources.create');
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
        'title' => 'required|unique:article_sources|max:100',
        ]);

       $source= new Source;
       $source->title = $request->title;
       $source->published=$request->published ? $request->published : 0 ;
       if ($source->save()) {
        session()->flash('message.type', 'success');
        session()->flash('message.content', 'Source ajouté avec succès!');
    } else {
        session()->flash('message.type', 'danger');
        session()->flash('message.content', 'Erreur lors de l\'ajout!');
    }
       if ($request->save_close) {
           return redirect()->route('article-sources.index');
       }else{
        return redirect()->route('article-sources.create');

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
       $source=Source::find($id);
       return view('article.sources.edit',compact('source'));
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
         $source=Source::find($id);
        $source->title = $request->title;
        $source->published=$request->published ? $request->published : 0 ;
        $source->save();

if ($request->update) {
        if ($source->save()) {
           
           session()->flash('message.type', 'success');
           session()->flash('message.content', 'Categorie modifiée avec succès!');
        } else {
           session()->flash('message.type', 'danger');
           session()->flash('message.content', 'Erreur lors de la modification!');
        }
    }else{
        session()->flash('message.type', 'danger');
        session()->flash('message.content', 'Modification annulée!');
    }
           return redirect()->route('article-sources.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $source= Source::with(['getArticles','getArchives'])->where('id',$id)->first();
   if ($source->getArticles->isEmpty() && $source->getArchives->isEmpty()) {
        if($source->delete()){
           session()->flash('message.type', 'success');
           session()->flash('message.content', 'Source supprimée avec succès!');
           } else {
           session()->flash('message.type', 'danger');
           session()->flash('message.content', 'Erreur lors de la suppression!');
        }
        } else {
           session()->flash('message.type', 'danger');
           session()->flash('message.content', 'Cette Source ne peut être supprimée car elle est referencée par un ou plusieurs Articles!');
        }

        return redirect()->route('article-sources.index');

    }
}
