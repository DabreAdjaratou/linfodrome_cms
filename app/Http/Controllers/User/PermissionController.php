<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\Resource;
use App\Models\User\Accesslevel;
use App\Models\User\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $resources=Resource::with('getActions')->get(['id','title']);
        $accessLevels=Accesslevel::all('id','title');
        return view('user.permissions.create',compact('resources','accessLevels'));
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
            'accessLevel' =>'required|int',
        ]);
       $resources=Resource::all('id','title');
       $permission= new Permission;
       $permission->access_level_id = $request->accessLevel;
       foreach ($resources as $r) {
        $title=$r->title;
        $actions=$request->$title;
        // dd(count($actions));
        for ($i=0; $i <count($actions) ; $i++) { 
           $permission->resource_id=$r->id;
           $permission->action_id=$actions[$i];
           $permission->save();
           }
       }
    //    $acions =$request->;
    //    if ($permission->save()) {
    //     session()->flash('message.type', 'success');
    //     session()->flash('message.content', 'permission ajouté avec succès!');
    // } else {
    //     session()->flash('message.type', 'danger');
    //     session()->flash('message.content', 'Erreur lors de l\'ajout!');
    // }
    //    if ($request->save_close) {
    //        return redirect()->route('actions.index');
    //    }else{
        return redirect()->route('actions.create');

    
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
