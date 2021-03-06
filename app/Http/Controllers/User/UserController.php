<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\User;
use App\Models\User\Group;
use App\Models\User\GroupChild;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\ResetsPasswords;

class UserController extends Controller
{

   use ResetsPasswords;
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
  
  // dd(Group::getPermissions(6));
 $users = User::all('id','name','email','is_active','require_reset','data');
 foreach ($users as $u) {
  $u->data=json_decode($u->data);
  $u->name= ucwords($u->name);

}

$userData = User::with(['getGroups.getAccessLevels.getPermissions.getResource','getGroups.getAccessLevels.getPermissions.getAction'])->where('id', 1)->get(['id']);


return view ('user.users.administrator.index', ['users'=>$users]);
}

/**
 * Show the form for creating a new resource.
 *
 * @return \Illuminate\Http\Response
 */
public function create()
{
  return view ('user.users.administrator.create');
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
  return view('user.users.administrator.edit',['arrayDiff'=>$arrayDiff,'user'=>$user,'allGroups'=>$allGroups, 'userGroups'=>$userGroups]);

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
    'groups'=>'required',     
  ]);
 }else{
  $validatedData=$request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|string|email|max:255|'.Rule::unique('users')->ignore($id, 'id'),
    'is_active'=>'required|integer',
    'image'=>'nullable|image',
    'require_reset'=>'required|integer', 
    'groups'=>'required',         
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
     # code...
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

/**
 * force user to reset paswword
 *
 * @param  int  $id
 * @return \Illuminate\Http\Response
 */
public function requireResetPassword($id)
{
  $user=User::find($id);
  return view('user.users.administrator.reset-password',compact('user'));

}

/**
 * reset user paswword if required
 *
 * @param  int  $id, Request $request
 * @return \Illuminate\Http\Response
 */
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
