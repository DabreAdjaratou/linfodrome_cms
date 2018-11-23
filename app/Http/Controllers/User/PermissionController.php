<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\Resource;
use App\Models\User\AccessLevel;
use App\Models\User\Permission;
use Illuminate\Support\Facades\DB;
use Validator;


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
        
        return view('user.permissions.administrator.index',compact('permissions'));
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
        return view('user.permissions.administrator.create',compact('resources','accessLevels'));
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
        for ($i=0; $i <$resources->count() ; $i++) { 
         if ($request->has($resources[$i]['title'])) {
             foreach ($resources as $r) {
                $title=$r->title;
                $actions=$request->$title;
                try {
                    DB::transaction(function () use ($actions,$request,$r) {
                      if($actions){
                       for ($i=0; $i <count($actions) ; $i++) { 
                         $permission= new Permission;
                         $permission->access_level_id = $request->accessLevel;
                         $permission->resource_id=$r->id;
                         $permission->action_id=$actions[$i];
                         $permission->save();
                     }
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
}
$validator = Validator::make($request->actions=[], [
    'actions' => 'required',
]);

if ($validator->fails()) {
    return back()
    ->withErrors($validator)
    ->withInput();
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
        $resources=Resource::with('getActions','getPermissions')->get(['id','title']);
        return view('user.permissions.administrator.edit',compact('resources','accessLevel'));
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
        if ($request->update) {

            $resources=Resource::all('id','title');
            for ($i=0; $i <$resources->count() ; $i++) { 
             if ($request->has($resources[$i]['title'])) {
                $existingPermissions=Permission::where('access_level_id',$id)->get();
                try {
                    DB::transaction(function () use ($request,$id,$resources,$existingPermissions) {
                        for ($i=0; $i <count($existingPermissions) ; $i++) { 
                            $existingPermissions[$i]->forceDelete();
                        }
                        foreach ($resources as $r) {
                            $title=$r->title;
                            $actions=$request->$title;
                            for ($i=0; $i <count($actions) ; $i++) { 
                             $permission= new Permission;
                             $permission->access_level_id = $id;
                             $permission->resource_id=$r->id;
                             $permission->action_id=$actions[$i];
                             $permission->save();
                         }
                     }
                 });

                } catch (Exception $e) {

                    session()->flash('message.type', 'danger');
                    session()->flash('message.content', 'Erreur lors de l\'ajout!');
                }
                session()->flash('message.type', 'success');
                session()->flash('message.content', 'Permissions modifiée avec succès!');
                return redirect()->route('permissions.index');

            }
        }
        $validator = Validator::make($request->actions=[], [
            'actions' => 'required',
        ]);

        if ($validator->fails()) {
            return back()
            ->withErrors($validator)
            ->withInput();
        }

    }else{
        session()->flash('message.type', 'danger');
        session()->flash('message.content', 'Modification annulée!');

    }
    return redirect()->route('permissions.index');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $access_level_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($access_level_id)
    {
        $permissions= Permission::where('access_level_id',$access_level_id)->get(['id']);
        foreach ($permissions as $p) {
          Permission::destroy($p->id);
      }
                session()->flash('message.type', 'success');
                session()->flash('message.content', 'Permissions Supprimées avec succès!');
                return redirect()->route('permissions.index');
  }
}
