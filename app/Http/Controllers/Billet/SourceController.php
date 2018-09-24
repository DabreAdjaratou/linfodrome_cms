<?php

namespace App\Http\Controllers\Billet;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Billet\Source;
use Illuminate\Validation\Rule;

class SourceController extends Controller
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
        $sources=Source::all();
        return view ('billet.sources.index',['sources'=>$sources]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('billet.sources.create');
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
        'title' => 'required|unique:billet_sources|max:100',
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
           return redirect()->route('billet-sources.index');
       }else{
        return redirect()->route('billets-sources.create');

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
       return view('billet.sources.edit',compact('source'));
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
         'title' => 'required|'.Rule::unique('billet_sources')->ignore($id, 'id').'|max:100',
        ]);
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
           return redirect()->route('billet-sources.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     public function destroy($id)
    {
        $source= Source::onlyTrashed()->find($id);
                if($source->forceDelete()){
           session()->flash('message.type', 'success');
           session()->flash('message.content', 'Source supprimée avec succès!');
           } else {
           session()->flash('message.type', 'danger');
           session()->flash('message.content', 'Erreur lors de la suppression!');
        }
        
        return redirect()->route('billet-sources.trash');
    }
    
    
    public function putInTrash($id)
    {
        $source= Source::with(['getBillets','getArchives'])->where('id',$id)->first();
        if ($source->getBillets->isEmpty() && $source->getArchives->isEmpty()) {
        
            if($source->delete()){
           session()->flash('message.type', 'success');
           session()->flash('message.content', 'Source mis en corbeille!!');
           } else {
           session()->flash('message.type', 'danger');
           session()->flash('message.content', 'Erreur lors de la mise en corbeille!');
        }
      } else {
           session()->flash('message.type', 'danger');
           session()->flash('message.content', 'Cette source ne peut être mise en corbeille car elle est referencée par un ou plusieurs articles!');
        }
  return redirect()->route('billet-sources.index');
    }

    public function restore($id)
    {
      
        Source::onlyTrashed()->find($id)->restore();
      session()->flash('message.type', 'success');
      session()->flash('message.content', 'source restaurer!');
      return redirect()->route('billet-sources.index');
   
    }

    public function inTrash()
    {
     $sources= Source::onlyTrashed()->get(['id','title']);
       return view('billet.sources.trash',compact('sources'));
   
        
    }
}