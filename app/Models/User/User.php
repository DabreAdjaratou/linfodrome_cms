<?php

namespace App\Models\User;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User\Group;

class User extends Authenticatable
{
  use Notifiable;
  use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
      'name', 'email', 'password','image','is_active','require_reset','data',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
      'password', 'remember_token',
    ];

    public function getGroups()
    {
      return $this->belongsToMany('App\Models\User\Group', 'user_usergroup_map', 'user_id', 'user_group_id');
    }

    public static function getPermissions($id,$resource,$action)
    {
      $userData = User::with(['getGroups.getAccessLevels.getPermissions.getResource','getGroups.getAccessLevels.getPermissions.getAction'])->where('id', $id)->get(['id']);
      foreach ($userData as $data) {
       foreach ($data->getGroups as $group) {
      // dd(blank($group->getAccessLevels));
        if(blank($group->getAccessLevels)){
       $parentPermissions=Group::getPermissions($group->id);
           $action=(action::where('title',$action)->get(['id','title']))->toArray();
           $resource=Resource::where('title',$resource)->get(['id','title']);
           for ($i=0; $i <count($parentPermissions) ; $i++) { 
             if ($parentPermissions[$i]['resource_id']==$resource[0]['id'] && $parentPermissions[$i]['action_id']==$action[0]['id'] && $parentPermissions[$i]['access_level_id']==$access->id) {
              return true;
            }
    }
    }else{
 foreach ($group->getAccessLevels as $access) {
         foreach ($access->getPermissions  as $permission) {
          $access_level= $access->title;
          $permission_resource= $permission->getResource->title;
          $permission_action= $permission->getAction->title;
          if ($permission_resource==$resource && $permission_action==$action) {
            return true;
          }else{
           $parentPermissions=Group::getPermissions($group->id);
           $action=(action::where('title',$action)->get(['id','title']))->toArray();
           $resource=Resource::where('title',$resource)->get(['id','title']);
           for ($i=0; $i <count($parentPermissions) ; $i++) { 
             if ($parentPermissions[$i]['resource_id']==$resource[0]['id'] && $parentPermissions[$i]['action_id']==$action[0]['id'] && $parentPermissions[$i]['access_level_id']==$access->id) {
              return true;
        }
            }
          }
        }
      }


      
      
  } 
}
}
return false;
}  

public static function isAdmin($id) {
  $userData = User::with(['getGroups.getAccessLevels'])->where('id', $id)->get(['id']);
  foreach ($userData as $data) {
   foreach ($data->getGroups as $group) {
    foreach ($group->getAccessLevels as $acces) {
     foreach ($acces as $a) {
       if(strcasecmp($group->title, 'Manager')==0){
        return true;
      }elseif(strcasecmp($group->title, 'public')==0){
        return false;
      }

    }

  }

}
}
}

}