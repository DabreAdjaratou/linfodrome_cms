<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\Action;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ActionController extends Controller
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

     $actions = Action::all('id','title','display_name');
     return view ('user.actions.administrator.index', ['actions'=>$actions]);
 }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('user.actions.administrator.create');
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
        'title' => 'required|unique:actions|max:100',
        'display_name'=>'required|max:30',
    ]);

     $action= new Action;
     $action->title = $request->title;
     $action->display_name =$request->display_name;
     if ($action->save()) {
        session()->flash('message.type', 'success');
        session()->flash('message.content', 'Action ajouté avec succès!');
    } else {
        session()->flash('message.type', 'danger');
        session()->flash('message.content', 'Erreur lors de l\'ajout!');
    }
    if ($request->save_close) {
     return redirect()->route('actions.index');
 }else{
    return redirect()->route('actions.create');

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
        $action=Action::find($id);
        return view('user.actions.administrator.edit',compact('action'));
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
           'title' => 'required|'.Rule::unique('actions')->ignore($id, 'id').'|max:100',
           'display_name'=>'required|max:30',
       ]);
        $action=Action::find($id);
        $action->title = $request->title;
        $action->display_name = $request->display_name;

        if ($request->update) {
         $action->save();
         session()->flash('message.type', 'success');
         session()->flash('message.content', 'Action modifier avec succès!');
     }else{
       session()->flash('message.type', 'danger');
       session()->flash('message.content', 'Modification annulée!');
   }
   return redirect()->route('actions.index');
   
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $action=Action::find($id);
        $existingInPivot=Action::with('getResources')->where('id',$action->id)->get();
        foreach ($existingInPivot as $e) {
            $existingResources=[];
            foreach ($e->getResources as $existingResource) {
             $existingResources[]=$existingResource->id;
         }
     }

     try {
       DB::transaction(function () use ($action,$existingResources) {
        $action->delete();
        for ($i=0; $i <count($existingResources) ; $i++) { 
           $action->getResources()->detach($existingResources[$i]);
       }
   });
   } catch (Exception $exc) {
       session()->flash('message.type', 'danger');
       session()->flash('message.content', 'Erreur lors de la suppression');
//           echo $exc->getTraceAsString();
   }
   session()->flash('message.type', 'success');
   session()->flash('message.content', 'Action supprimer avec succès!');
   return redirect()->route('actions.index');
}
}
