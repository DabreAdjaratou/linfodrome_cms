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
        // foreach ($groups as $g) {
    //         $g['title']='-'.$g['title'];
    //         foreach ($g->getChildrens as $c) {
    //          $c['title']='--'.$c['title'];
    //          $g['get_childrens']=$g->getChildrens->toArray();
    //          $c['get_childrens']=$c->getChildrens;
    //          foreach ($c['get_childrens'] as $c2) {
    //             $c2['title']='---'.$c2['title'];
    //             $c2['get_childrens']=$c2->getChildrens;
    //             foreach ($c2['get_childrens'] as $c3) {
    //             $c3['title']='----'.$c3['title'];
    //             $c3['get_childrens']=$c3->getChildrens;
    //         }
    //         }

    //     }

    // }
  
    // return view ('user.groups.index', ['groups'=>$groups->toArray()]);
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

    public function fore(Array $group){

        for ($i=0; $i <count($group) ; $i++) { 
         $group[$i]='<tr>
         <td><input type="checkbox" name="" class="uk-checkbox"></td>
         <td>'. $group[$i].'</td>
         <td> {{$group[$i][id]</td>
            </tr>';

        }
        return $group;

    }
}
