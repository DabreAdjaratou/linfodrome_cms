<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\Action;


class ActionController extends Controller
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
       $actions = Action::all();
       return view ('user.actions.index', ['actions'=>$actions]);
   }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('user.actions.create');
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
        $request->session()->flash('message.type', 'success');
        $request->session()->flash('message.content', 'Action ajouté avec succès!');
    } else {
        $request->session()->flash('message.type', 'danger');
        $request->session()->flash('message.content', 'Erreur lors de l\'ajout!');
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
