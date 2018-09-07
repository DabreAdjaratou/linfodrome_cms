<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\Group;
use App\Models\User\Accesslevel;
use Illuminate\Support\Collection;


class GroupController extends Controller
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
        $groups = Group::with('getChildrens')->where('parent_id',0)->get();

               $accessLevels=Accesslevel::all();
              $groups2 = Group::all();
        foreach ($groups2 as $g) {
//         //     $g->title= ucfirst($g->title);
//         //   foreach ($g->getChildrens as $g2) {
             
//         //       foreach ($g2->getChildrens as $g3) {
//         //          echo $g3;
//         //   }

        
//         // }

foreach ($accessLevels as $key=> $a) {
    $collection = new Collection();
// echo $a->groups;

    $accessGroups=json_decode($a->groups);
for ($i=0; $i <count($accessGroups) ; $i++) { 
    
 if ($accessGroups[$i]==$g->id){
    $access[]=$a->title;
  // echo 'group :'.$g->title.' ';
  // echo 'access :'.$a->title.'<br> ';
    }
// $array2=array_merge($array);
  // echo   $collection->access;
     
}
        }
    }   

        echo'<pre>';     
print_r($access);
        echo'</pre>';         

return view ('user.groups.index', ['groups'=>$groups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parents = Group::all();
     return view ('user.groups.create',['parents'=>$parents]);
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
        $request->session()->flash('message.type', 'success');
        $request->session()->flash('message.content', 'Groupe ajouté avec succès!');
    } else {
        $request->session()->flash('message.type', 'danger');
        $request->session()->flash('message.content', 'Erreur lors de l\'ajout!');
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
