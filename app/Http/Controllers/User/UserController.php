<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
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
   $users = User::all('id','name','email','is_active','require_reset','data');
     foreach ($users as $u) {
          $u->data=json_decode($u->data);
          $u->name= ucwords($u->name);
      }

      $userData = User::with(['getGroups.getAccessLevels.getPermissions.getResource','getGroups.getAccessLevels.getPermissions.getAction'])->where('id', 1)->get(['id']);
      
//         foreach ($userData as $data) {
//          foreach ($data->getGroups as $group) {
//           echo '<pre>';
//           ($group->getParents);
//           echo '</pre>';
//           foreach ($group->getAccessLevels as $acces) {
//            foreach ($acces->getPermissions  as $key=>$permission) {
//               $access_level= $acces->title;
//               $permission_resource= $permission->getResource->title;
//               $permission_action= $permission->getAction->title;
//               // if ($permission_resource==$resource && $permission_action==$action) {
//               //     return true;
//               // }

//           }

//       }
//   } 
// }
     return view ('user.users.index', ['users'=>$users]);
}

/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */
public function create()
{
    return view ('user.users.create');
}

/**
 * Store a newly created resource in storage.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\Response
 */
public function store(Request $request)
{
  
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
