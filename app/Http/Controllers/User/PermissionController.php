<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\Resource;
use App\Models\User\AccessLevel;
use App\Models\User\Permission;
use Illuminate\Support\Facades\DB;


class PermissionController extends Controller
{
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
        $permissions=Permission::with('getAction','getAccessLevel','getResource')->get(['access_level_id','resource_id','action_id'])->groupBy('access_level_id');
        // $permissions=Accesslevel::with('getPermissions.getResource.getActions')->get();

        // die(print_r($permissions));
        return view('user.permissions.index',compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $resources=Resource::with('getActions')->get(['id','title']);
        $accessLevels=AccessLevel::all('id','title');
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
        foreach ($resources as $r) {
            $title=$r->title;
            $actions=$request->$title;

            try {
                DB::transaction(function () use ($actions,$request,$r) {
                   for ($i=0; $i <count($actions) ; $i++) { 
                     $permission= new Permission;
                     $permission->access_level_id = $request->accessLevel;
                     $permission->resource_id=$r->id;
                     $permission->action_id=$actions[$i];
                     $permission->save();
                 }
             });

            } catch (Exception $e) {

                session()->flash('message.type', 'danger');
                session()->flash('message.content', 'Erreur lors de l\'ajout!');
            }
            session()->flash('message.type', 'success');
            session()->flash('message.content', 'permission ajouté avec succès!');


        }

        if ($request->save_close) {
         return redirect()->route('permissions.index');
     }else{
        return redirect()->route('permissions.create');
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
        $accessLevel=Accesslevel::find($id);

        $permissions=Permission::with('getAction','getAccessLevel','getResource')->where('access_level_id',$id)->get(['access_level_id','resource_id','action_id']);
        $resources=Resource::with('getActions','getPermissions')->get(['id','title']);
       // dd($resources);
       // $allActions=Action::all();
        foreach ($resources as $resource) {
            foreach ($resource->getActions as $resourceAction) {
             $resourceActions[]=$resourceAction->id;
            }
       foreach ($permissions as $p) {
        $actions[]=$p->action_id;
           
        $resourceActions=[];
                # code...
                    }
    }
    $arrayDiff=array_diff($actions, $resourceActions);
    // dd($arrayDiff);
               return view('user.permissions.edit',compact('resources','accessLevels','accessLevel','permissions','arrayDiff'));
    // return view ('user.resources.edit',['arrayDiff'=>$arrayDiff,'resource'=>$resource,'allActions'=>$allActions]);
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
