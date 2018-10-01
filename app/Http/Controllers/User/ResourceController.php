<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\Resource;
use App\Models\User\Action;
use App\Models\User\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ResourceController extends Controller
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
        $resources = Resource::with('getActions:title')->get(['id','title','display_name']);  
        foreach ($resources as $d) {
          foreach ($d->getActions as $action) {
             if ($d->getActions->last()->title==$action->title) {
               $action->title= $action->title;
           }else{
            $action->title= $action->title.',';
        }
    }
}

return view ('user.resources.administrator.index', compact('resources'));


}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $actions=Action::all();
        return view ('user.resources.administrator.create',compact('actions'));
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
            'display_name' => 'required|unique:resources|max:100',
            'actions'=>'required',
        ]);
        $resource= new Resource;
        $resource->title = $request->title;
        $resource->display_name= $request->display_name;
        $actions =$request->actions;


try {
         DB::transaction(function () use ($resource,$actions) {
          $resource->save();
                  for ($i=0; $i <count($actions) ; $i++) { 
             $resource->getActions()->attach($actions[$i]);
         }
     });
     } catch (Exception $exc) {
         session()->flash('message.type', 'danger');
        session()->flash('message.content', 'Erreur lors de l\'ajout!');
//           echo $exc->getTraceAsString();
    }
session()->flash('message.type', 'success');
session()->flash('message.content', 'Resource ajouté avec succès!');
if ($request->save_close) {
           return redirect()->route('resources.index');
       }else{
        return redirect()->route('resources.create');

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
       $resource=Resource::find($id);
       $allActions=Action::all();
       foreach ($allActions as $a) {
        $actions[]=$a->title;
        $resourceActions=[];
        foreach ($resource->getActions as $resourceAction) {
            $resourceActions[]=$resourceAction->title;
        }
    }
    $arrayDiff=array_diff($actions, $resourceActions);
    return view ('user.resources.administrator.edit',['arrayDiff'=>$arrayDiff,'resource'=>$resource,'allActions'=>$allActions]);
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
         'title' => 'required|'.Rule::unique('resources')->ignore($id, 'id').'|max:100',
         'display_name' => 'required|'.Rule::unique('resources')->ignore($id, 'id').'|max:100',
         'actions'=>'required',
         ]);
        $resource=Resource::find($id);
        $resource->title = $request->title;
        $resource->display_name = $request->display_name;
        $actions =$request->actions;
        // $existing=Resource::find($resource->id);
        $existingInPivot=Resource::with('getActions')->where('resources.id',$resource->id)->get();
        foreach ($existingInPivot as $e) {
            $existingActions=[];
            foreach ($e->getActions as $existingAction) {
               $existingActions[]=$existingAction->id;
           }
       }

        if ($request->update) {
            try {
         DB::transaction(function () use ($resource,$existingActions,$actions) {
          $resource->save();
          for ($i=0; $i <count($existingActions) ; $i++) { 
             $resource->getActions()->detach($existingActions[$i]);
         }
         for ($i=0; $i <count($actions) ; $i++) { 
             $resource->getActions()->attach($actions[$i]);
         }
     });
     } catch (Exception $exc) {
        
        session()->flash('message.type', 'danger');
        
        session()->flash('message.content', 'Erreur lors de la modification!');
//           echo $exc->getTraceAsString();
    }
    
    session()->flash('message.type', 'success');
    
    session()->flash('message.content', 'Resource Modifier avec succès!');

        }else{
 session()->flash('message.type', 'danger');
        session()->flash('message.content', 'Modification annulée!');
        }
       
     
    return redirect()->route('resources.index');

}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resource=Resource::find($id);
        $existing=Resource::with(['getActions','getPermissions'])->where('resources.id',$resource->id)->get();
        foreach ($existing as $e) {
            $existingActions=[];
            $existingPermissions=[];
            foreach ($e->getActions as $existingAction) {
               $existingActions[]=$existingAction->id;
           }
           foreach ($e->getPermissions as $existingPermission) {
                  $existingPermissions[]=$existingPermission->id;
           }
       }
       try {
         DB::transaction(function () use ($resource,$existingActions,$existingPermissions) {
          $resource->delete();
          for ($i=0; $i <count($existingActions) ; $i++) { 
             $resource->getActions()->detach($existingActions[$i]);
         }

         // for ($i2=0; $i2 <count($existingPermissions) ; $i2++) { 
             Permission::destroy($existingPermissions);
         // }

              });
     } catch (Exception $exc) {
        session()->flash('message.type', 'danger');
        session()->flash('message.content', 'Erreur lors de la suppression!');
//           echo $exc->getTraceAsString();
    }
    session()->flash('message.type', 'success');
    session()->flash('message.content', 'Resource supprimer avec succès!');

   
       return redirect()->route('resources.index');
    }
}
