<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\User;
use App\Models\User\Group;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
     /**
     * Protecting routes
     */
     public function __construct()
     {
       $this->middleware('auth');
       $this->middleware('activeUser')->except(['requireResetPassword','resetPassword']);

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
  $user=User::find($id);
  $allGroups = Group::with('getChildren')->where('parent_id',0)->get();
  $allGroups2=Group::all();
  foreach ($allGroups2 as $a) {
    $groups[]=$a->title;
    $userGroups=[];

    foreach ($user->getGroups as $userGroup) {
      $userGroups[]=$userGroup->title;
    }
  }

  $arrayDiff=array_diff($groups, $userGroups);
  return view('user.users.edit',['arrayDiff'=>$arrayDiff,'user'=>$user,'allGroups'=>$allGroups, 'userGroups'=>$userGroups]);

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
  if ($request->password) {
   $validatedData=$request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|string|email|max:255|'.Rule::unique('users')->ignore($id, 'id'),
    'password' => 'string|min:6|confirmed',
    'is_active'=>'required|integer',
    'image'=>'nullable|image',
    'require_reset'=>'required|integer',       
  ]);
 }else{
  $validatedData=$request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|string|email|max:255|'.Rule::unique('users')->ignore($id, 'id'),
    'is_active'=>'required|integer',
    'image'=>'nullable|image',
    'require_reset'=>'required|integer',        
  ]);
}

$user=User::find($id);
$user->name=$request->name;
$user->email=$request->email;
if ($request->password) {
$user->password=Hash::make($request->password);
}
$user->is_active=$request->is_active;
$user->image=$request->image?? NULL;
$user->require_reset=$request->require_reset;
$user->data= '{"title":"'.$request->title.'","google":"'.$request->google.'","twitter":"'.$request->twitter.'","facebook":"'.$request->facebook.'"}';
$groups= $request->groups;
$existingInPivot=User::with('getGroups')->where('id',$user->id)->get();
foreach ($existingInPivot as $e) {
  $existingGroups=[];
  foreach ($e->getGroups as $existingGroup) {
   $existingGroups[]=$existingGroup->id;
 }
}
if ($request->update) {
  try {
   DB::transaction(function () use ($user,$existingGroups,$groups) {
    $user->save();
    for ($i=0; $i <count($existingGroups) ; $i++) { 
     $user->getGroups()->detach($existingGroups[$i]);
   }
   for ($i=0; $i <count($groups) ; $i++) { 
     $user->getGroups()->attach($groups[$i]);
   }
 });
 } catch (Exception $exc) {
  session()->flash('message.type', 'danger');
  session()->flash('message.content', 'Erreur lors de la modification!');
//           echo $exc->getTraceAsString();
}

session()->flash('message.type', 'success');
session()->flash('message.content', 'Utilisateur Modifier avec succès!');

}else{
 session()->flash('message.type', 'danger');
 session()->flash('message.content', 'Modification annulée!');
}       
return redirect()->route('users.index');
}
/**
 * Remove the specified resource from storage.
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function destroy($id)
{
}

public function requireResetPassword($id)
{
  $user=User::find($id);
  return view('user.users.reset-password',compact('user'));

}

public function resetPassword(Request $request,$id)
{
   $validatedData=$request->validate([
    'password' => 'string|min:6|confirmed',
     ]);
     $user=User::find($id);
  $user->password=Hash::make($request->password);
  $user->require_reset=1;
  if ( $request->update) {
    if ( $user->save()) {
      session()->flash('message.type', 'success');
session()->flash('message.content', 'Mot de passe Modifié avec succès!');
    }else{
       session()->flash('message.type', 'danger');
  session()->flash('message.content', 'Erreur lors de la modification!');
    }
  }else{
  session()->flash('message.type', 'danger');
  session()->flash('message.content', 'Modification annulée!');

  }
  return redirect()->route('administrator');

}
}
