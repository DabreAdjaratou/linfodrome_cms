<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\AccessLevel;
use App\Models\User\Group;

class AccessLevelController extends Controller
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
        
        $accessLevels = AccessLevel::all();  
        foreach ($accessLevels as $a) {
          $groups= json_decode($a->groups);
          $a->groups='';
          
          for($i=0; $i < count($groups);$i++){
             if ($i+1 ==count($groups)) {
                     $a->groups .=ucfirst(AccessLevel::getGoup($groups[$i])->title);   
             } else {
                                  $a->groups .=ucfirst(AccessLevel::getGoup($groups[$i])->title.', ');
                 
             }
          }
              
        }
        
       
return view ('user.access-levels.index', ['accessLevels'=>$accessLevels]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups=Group::all();
         return view ('user.access-levels.create',['groups'=>$groups]);
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
        $accessLevel->groups= json_encode($request->groups);

         if ($accessLevel->save()) {
        $request->session()->flash('message.type', 'success');
        $request->session()->flash('message.content', 'Niveau d\'acces ajouté avec succès!');
    } else {
        $request->session()->flash('message.type', 'danger');
        $request->session()->flash('message.content', 'Erreur lors de l\'ajout!');
    }
    if ($request->save_close) {
           return redirect()->route('access-levels.index');
       }else{
        return redirect()->route('access-levels.create');

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
