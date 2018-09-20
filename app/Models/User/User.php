<?php

namespace App\Models\User;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;
    
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
          foreach ($group->getAccessLevels as $acces) {
           foreach ($acces->getPermissions  as $key=>$permission) {
              $access_level= $acces->title;
              $permission_resource= $permission->getResource->title;
              $permission_action= $permission->getAction->title;
              if ($permission_resource==$resource && $permission_action==$action) {
                  return true;
              }

          }

      }
  } 
}
return false;
}   
}
