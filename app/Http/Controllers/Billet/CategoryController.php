<?php

namespace App\Http\Controllers\Billet;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Billet\Category;
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
        return view('billet.categories.index',['categories'=>$categories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    return view('billet.categories.create');
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
        'title' => 'required|unique:billet_categories|max:100',
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
           return redirect()->route('billet-categories.index');
       }else{
        return redirect()->route('billet-categories.create');

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
        return view('billet.categories.edit',compact('category'));
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
            'title' => 'required|'.Rule::unique('billet_categories')->ignore($id, 'id').'|max:100',
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
           return redirect()->route('billet-categories.index');
  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    $category= Category::with(['getBillets','getArchives'])->where('id',$id)->first();
   if ($category->getBillets->isEmpty() && $category->getArchives->isEmpty()) {
        if($category->delete()){
           session()->flash('message.type', 'success');
           session()->flash('message.content', 'Categorie supprimée avec succès!');
           } else {
           session()->flash('message.type', 'danger');
           session()->flash('message.content', 'Erreur lors de la suppression!');
        }
        } else {
           session()->flash('message.type', 'danger');
           session()->flash('message.content', 'Cette categorie ne peut être supprimée car elle est referencée par un ou plusieurs billets!');
        }

        return redirect()->route('billet-categories.index');

    }
}