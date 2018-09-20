<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\AccessLevel;
use App\Models\User\Group;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AccessLevelController extends Controller
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

        $accessLevels = AccessLevel::with('getGroups:title')->get(['id','title']);  
        foreach ($accessLevels as $a) {
          foreach ($a->getGroups as $group) {
            
             if ($a->getGroups->last()->title==$group->title) {
               $group->title= $group->title;
           }else{
            $group->title= $group->title.',';
           }
          }
              }
       
        return view ('user.access-levels.index', compact('accessLevels'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         $groups = Group::with('getChildren')->where('parent_id',0)->get();
        return view ('user.access-levels.create',['groups'=>$groups,'accessLevelView'=>'accessLevelView']);
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
            'title' => 'required|unique:access_levels|max:100',
        ]);

        $accessLevel = new AccessLevel;
        $accessLevel->title = $request->title;
        $groups= $request->groups;

try {
         DB::transaction(function () use ($accessLevel,$groups) {
          $accessLevel->save();
                  for ($i=0; $i <count($groups) ; $i++) { 
             $accessLevel->getGroups()->attach($groups[$i]);
         }
     });
     } catch (Exception $exc) {
         session()->flash('message.type', 'danger');
        session()->flash('message.content', 'Erreur lors de l\'ajout!');
//           echo $exc->getTraceAsString();
    }

session()->flash('message.type', 'success');
session()->flash('message.content', 'Niveau d\' ajouté avec succès!');
        
return redirect()->route('access-levels.index');

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
       $accessLevel=AccessLevel::with('getGroups')->find($id);
       $allGroups = Group::with('getChildren')->where('parent_id',0)->get();
       $allGroups2=Group::all();
       foreach ($allGroups2 as $a) {
        $groups[]=$a->title;
        $accessLevelGroups=[];
        // dd($accessLevel);
        foreach ($accessLevel->getGroups as $accessLevelGroup) {
            $accessLevelGroups[]=$accessLevelGroup->title;
        }
    }
       
    $arrayDiff=array_diff($groups, $accessLevelGroups);
 return view('user.access-levels.edit',['arrayDiff'=>$arrayDiff,'accessLevel'=>$accessLevel,'allGroups'=>$allGroups, 'accessLevelGroups'=>$accessLevelGroups,'view'=>'view']);
        
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
            'title' => 'required|'.Rule::unique('access_levels')->ignore($id, 'id').'|max:100',
        ]);
        $accessLevel =AccessLevel::find($id);
        $accessLevel->title = $request->title;
        $groups= $request->groups;
       $existingInPivot=AccessLevel::with('getGroups')->where('id',$accessLevel->id)->get();
        foreach ($existingInPivot as $e) {
            $existingGroups=[];
            foreach ($e->getGroups as $existingGroup) {
               $existingGroups[]=$existingGroup->id;
           }
       }

        if ($request->update) {
            try {
         DB::transaction(function () use ($accessLevel,$existingGroups,$groups) {
          $accessLevel->save();
          for ($i=0; $i <count($existingGroups) ; $i++) { 
             $accessLevel->getGroups()->detach($existingGroups[$i]);
         }
         for ($i=0; $i <count($groups) ; $i++) { 
             $accessLevel->getGroups()->attach($groups[$i]);
         }
     });
     } catch (Exception $exc) {
        
        session()->flash('message.type', 'danger');
        
        session()->flash('message.content', 'Erreur lors de la modification!');
//           echo $exc->getTraceAsString();
    }
    
    session()->flash('message.type', 'success');
    
    session()->flash('message.content', 'Niveau d\'accès Modifier avec succès!');

        }else{
 session()->flash('message.type', 'danger');
        session()->flash('message.content', 'Modification annulée!');
        }       
    return redirect()->route('access-levels.index');
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
