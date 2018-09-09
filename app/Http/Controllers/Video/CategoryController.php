<?php

namespace App\Http\Controllers\Video;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Video\Category;

class CategoryController extends Controller
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
     $categories=Category::all();
     return view('video.categories.index',['categories'=>$categories]);   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('video.categories.create');
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
        'title' => 'required|unique:video_categories|max:100',
        'published' => 'required|int',
        ]);

       $categorie= new Category;
       $categorie->title = $request->title;
       $categorie->alias=str_slug($request->title);
       $categorie->published = $request->published;
       if ($categorie->save()) {
        $request->session()->flash('message.type', 'success');
        $request->session()->flash('message.content', 'Categorie ajouté avec succès!');
    } else {
        $request->session()->flash('message.type', 'danger');
        $request->session()->flash('message.content', 'Erreur lors de l\'ajout!');
    }
       
        if ($request->save_close) {
           return redirect()->route('video-categories.index');
       }else{
        return redirect()->route('video-categories.create');

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
