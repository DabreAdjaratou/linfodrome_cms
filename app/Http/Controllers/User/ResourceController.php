<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\Resource;
use App\Models\User\Action;


class ResourceController extends Controller
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
        $resources = Resource::all();
        foreach ($resources as $r) {
            // echo $r->getActions;
          $actions= json_decode($r->actions);
          $r->actions='';
          
          for($i=0; $i < count($actions);$i++){
             if ($i+1 ==count($actions)) {
                     $r->actions .= ucfirst(Resource::getAction($actions[$i])->title);   
             } else {
                                  $r->actions .= ucfirst(Resource::getAction($actions[$i])->title.', ');
                 
             }
          }
          $r->title= ucfirst($r->title);    
        }
return view ('user.resources.index', ['resources'=>$resources]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $actions=Action::all();
         return view ('user.resources.create',['actions'=>$actions]);
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
        'title' => 'required|unique:resources|max:100',
        ]);

        $resource= new Resource;

        $resource->title = $request->title;
       
        $resource->actions =json_encode($request->actions);

        if ($resource->save()) {
        $request->session()->flash('message.type', 'success');
        $request->session()->flash('message.content', 'Resource ajouté avec succès!');
    } else {
        $request->session()->flash('message.type', 'danger');
        $request->session()->flash('message.content', 'Erreur lors de l\'ajout!');
    }
    if ($request->save_close) {
           return redirect()->route('resources.index');
       }else{
        return redirect()->route('resources.create');

    }
     return redirect()->route('resources.index');
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
