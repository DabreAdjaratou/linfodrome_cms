<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\AccessLevel;

class AccessLevelController extends Controller
{
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
                     $a->groups .=AccessLevel::getGoup($groups[$i])->title;   
             } else {
                                  $a->groups .=AccessLevel::getGoup($groups[$i])->title.', ';
                 
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
         return view ('user.access-levels.create');
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

        $accessLevel->save();
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
