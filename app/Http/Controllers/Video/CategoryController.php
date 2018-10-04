<?php

namespace App\Http\Controllers\Video;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Video\Category;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
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
     $categories=Category::all();
     return view('video.categories.administrator.index',['categories'=>$categories]);   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('video.categories.administrator.create');
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
        'published' => 'nullable|int',
        ]);

       $category= new Category;
       $category->title = $request->title;
       $category->alias=str_slug($request->title);
        $category->published=$request->published ? $request->published : 0 ;
       if ($category->save()) {
        session()->flash('message.type', 'success');
        session()->flash('message.content', 'Categorie ajouté avec succès!');
    } else {
        session()->flash('message.type', 'danger');
        session()->flash('message.content', 'Erreur lors de l\'ajout!');
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
        $category=Category::find($id);
        return view('video.categories.administrator.edit',compact('category'));
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
            'title' => 'required|'.Rule::unique('video_categories')->ignore($id, 'id').'|max:100',
            'published' => 'nullable|int',
        ]);
        $category=Category::find($id);
        $category->title = $request->title;
        $category->alias=str_slug($request->title);
        $category->published=$request->published ? $request->published : 0 ;
    
    if ($request->update) {
        if ($category->save()) {
           
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
           return redirect()->route('video-categories.index');
  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
    {
        $category= Category::onlyTrashed()->find($id);
                if($category->forceDelete()){
           session()->flash('message.type', 'success');
           session()->flash('message.content', 'Categorie supprimée avec succès!');
           } else {
           session()->flash('message.type', 'danger');
           session()->flash('message.content', 'Erreur lors de la suppression!');
        }
        
        return redirect()->route('video-categories.trash');
    }
    
    /**
     * put the specified resource in the trash.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function putInTrash($id)
    {
        $category= Category::with(['getVideos','getArchives'])->where('id',$id)->first();
        if ($category->getVideos->isEmpty() && $category->getArchives->isEmpty()) {
        
            if($category->delete()){
           session()->flash('message.type', 'success');
           session()->flash('message.content', 'Categorie mis en corbeille!!');
           } else {
           session()->flash('message.type', 'danger');
           session()->flash('message.content', 'Erreur lors de la mise en corbeille!');
        }
      } else {
           session()->flash('message.type', 'danger');
           session()->flash('message.content', 'Cette categorie ne peut être mise en corbeille car elle est referencée par un ou plusieurs articles!');
        }
  return redirect()->route('video-categories.index');
    }
/**
     * restore the specified resource from the trash.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
      
        Category::onlyTrashed()->find($id)->restore();
      session()->flash('message.type', 'success');
      session()->flash('message.content', 'Categorie restaurer!');
      return redirect()->route('video-categories.trash');
   
    }
/**
     * Display a listing of the resource in the trash.
     *
     * @return \Illuminate\Http\Response
     */
    public function inTrash()
    {
     $categories= Category::onlyTrashed()->get(['id','title']);
       return view('video.categories.administrator.trash',compact('categories'));
   
        
    }
}
