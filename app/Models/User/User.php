<?php

namespace App\Models\User;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User\Group;
use App\Models\User\Action;

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

/**
*get user's groups
*@param
*@return item collection
*
**/
    public function getGroups()
    {
      return $this->belongsToMany('App\Models\User\Group', 'user_usergroup_map', 'user_id', 'user_group_id');
    }


/**
*check if a user has a right to access to a resource'action
*@param int $id, string $resource, string $action
*@return boolean
*
**/
    public static function getPermissions($id,$resource,$action)
    {
      $userData = User::with(['getGroups'])->where('id', $id)->get(['id']);
      $userPermissions=collect([]);
      foreach ($userData as $data) {
       foreach ($data->getGroups as $group) {
        $groupPermission=Group::getPermissions($group->id);
        foreach ($groupPermission as $p) {
          $userPermissions->push($p);
        }
      }
      for ($i=0; $i <count($userPermissions) ; $i++) {
        $permission_resource= $userPermissions[$i]->getResource->title;
        $permission_action= $userPermissions[$i]->getAction->title;
        $requestedAction=Action::where('title',$action)->get(['id','title']);
        $requestedResource=Resource::where('title',$resource)->get(['id','title']);

        if ($userPermissions[$i]['resource_id']==$requestedResource[0]['id'] && $userPermissions[$i]['action_id']==$requestedAction[0]['id']) {
          return true;
        }
      }
    }
    return false;
  }

/**
*grant all right to a admin group and remove all right to public group
*@param int $id
*@return boolean
*
**/
  public static function isAdmin($id) {
    $userData = User::with(['getGroups'])->where('id', $id)->get(['id']);
    foreach ($userData as $data) {
     foreach ($data->getGroups as $group) {
      if(strcasecmp($group->title, 'guest')==0){
        return true;
      }elseif(strcasecmp($group->title, 'public')==0){
        return false;
      }
    }
  }
}

}