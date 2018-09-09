<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User\User;

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
               if ($u->is_active==1) {
          $u->is_active=' <span class="uk-border-circle uk-text-success uk-text-bold uk-margin-small-left icon-container">✔</span>';
      } else {
        $u->is_active='<span class="uk-border-circle uk-text-danger uk-text-bold uk-margin-small-left icon-container">✖</span>';
         
      }
      $u->name= ucwords($u->name);
      foreach ($u->getGroups as $g) {
         $h=json_decode($g);
         echo $h->title;
       } ;

          }
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
