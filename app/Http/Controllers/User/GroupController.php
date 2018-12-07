<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\Group;
use App\Models\User\Action;
use App\Models\User\Resource;
use Illuminate\Validation\Rule;


class GroupController extends Controller
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
        $groups = Group::where('parent_id',0)->get();
        $view='groupView';
               
    return view ('user.groups.administrator.index', compact('groups','view'));

         }    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parents = Group::all();
        return view ('user.groups.administrator.create',['parents'=>$parents]);
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
            'title' => 'required|unique:user_groups|max:100',
        ]);

        $group = new Group;
        $group->title = $request->title;
        $group->parent_id = $request->parent;
        if ($group->save()) {
            
            session()->flash('message.type', 'success');
            
            session()->flash('message.content', 'Groupe ajouté avec succès!');
        } else {
            
            session()->flash('message.type', 'danger');
            
            session()->flash('message.content', 'Erreur lors de l\'ajout!');
        }
        if ($request->save_close) {
         return redirect()->route('user-groups.index');
     }else{
        return redirect()->route('user-groups.create');

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
        $r=Group::getPermissions($id);
  dd(Group::getPermissions($id));
        // for ($i=0; $i <count($r); $i++) { 
        //     echo $r[$i]['resource_id'];
        //     $action=Action::where('title','CREATE')->get(['id','title'])->toArray();
        //     echo $action[0]['title'];
        //     $resource=Resource::where('title','article')->get(['id','title']);
        //     echo $resource[0]['title'];

        // }

              $group=Group::find($id);
// $this->getPermissions($id);
        $parents = Group::all();
        return view ('user.groups.administrator.edit',compact('parents','group'));
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
            'title' => 'required|'.Rule::unique('user_groups')->ignore($id, 'id').'|max:100',
        ]);
        $group = Group::find($id);
        $group->title = $request->title;
        $group->parent_id = $request->parent;
        if ($request->update) {
           $group->save();
        session()->flash('message.type', 'success');
        session()->flash('message.content', 'Group modifier avec succès!');
        }else{
 session()->flash('message.type', 'danger');
        session()->flash('message.content', 'Modification annulée!');
        }
        return redirect()->route('user-groups.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       $group=Group::with(['getUsers:id,name','getChildren','getAccessLevels'])->find($id);
       if(blank($group->getUsers) && blank($group->getChildren) && blank($group->getAccessLevels)){
        $group->forceDelete();
        session()->flash('message.type', 'success');
        session()->flash('message.content', 'Group supprimé avec succès!');
       }else{
        session()->flash('message.type', 'danger');
        session()->flash('message.content', 'Impossible de supprimer ce groupe car il est referencé par d\'autre elements!');
       }
       return redirect()->route('user-groups.index');
    }

    
}
