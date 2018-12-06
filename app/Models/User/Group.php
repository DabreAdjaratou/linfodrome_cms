<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\AccessLevel;
use App\Models\User\Permission;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model {

    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'user_groups';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'parent_id',
    ];

/**
*get group's children
*@param
*@return item collection
*
**/
    public function getChildren() {
        return $this->hasMany('App\Models\User\Group', 'parent_id');
    }
/**
*get group's parent 
*@param
*@return item collection
*
**/
    public function getParent() {
        return $this->belongsTo('App\Models\User\Group', 'parent_id');
    }
/**
* get users that belongs to a access level 
*@param
*@return collection of items
*
*/
    Public function getAccessLevels() {
        return $this->belongsToMany('App\Models\User\AccessLevel', 'usergroup_accesslevel_map', 'user_group_id');
    }

/**
* get users that belong to a groups 
*@param
*@return collection of items
*
*/
     Public function getUsers() {
        return $this->belongsToMany('App\Models\User\User', 'user_usergroup_map', 'user_group_id');
    }

/**
     * get permissions for the specify group. 
     *the group permissions is the set of permissions of all access levels that group and  it parent belong's to
     *@param int $id
     * @return array $permission
     */
    public static function getPermissions($id) {
        $group = Group::find($id);
        // $permissions = [];
        // $Allpermissions=[];
        // get group own permissions via its access levels
        // foreach ($group->getAccessLevels as $accessLevel) {
        //     foreach ($accessLevel->getPermissions as $permission) {
        //         $permissions[] = $permission;
        //     }
        // }
        $parents = collect([$id]);

       $parent = $group->parent_id;
      while($parent) {
        $parents->push($parent);
        $p = Group::find($parent);
        $parent=$p->parent_id;
    }
    $allAccessLevels=collect([]);
for($i=0; $i < sizeof($parents); $i++){
    $accessLevel= AccessLevel::join('usergroup_accesslevel_map', 'access_levels.id', '=', 'usergroup_accesslevel_map.access_level_id')
     ->where('user_group_id',$parents[$i])->get();
     foreach ($accessLevel as $a) {
        $allAccessLevels->push($a->access_level_id);
     }
}
    $permissions=collect([]);
for($i=0; $i < sizeof($allAccessLevels); $i++){
    $permission= Permission::where('access_level_id',$allAccessLevels[$i])->get();
    // join('access_levels', 'access_levels.id', '=', 'Permissions.access_level_id')
    //  ->where('access_level_id',$allAccessLevels[$i])->get();
     foreach ($permission as $p) {
        $permissions->push($p);
     }
}
return $permissions;
// if the group has a parent, get parent permissions and merge with group permissions and return all permissions
//       if ($group->parent_id != 0) {
//         $parent = Group::with(['getParent', 'getAccessLevels.getPermissions'])->find($id);
//         $parentPermissions = Group::getParentPermissions($group->parent_id);
// }
              // return Group::allPermissions($permissions,$parentPermissions);
    }


/**
     * get permissions for the specify group if that group doesn't belong to any access level.
     * in this case the group inherit of it parent permissions
     * @return \Illuminate\Http\Re
     */
    public static function getPermissionsIfNoAccessLevel($id) {
        $group = Group::with(['getParent', 'getAccessLevels.getPermissions'])->find($id);
        $parentPermissions = [];
//        $accessLevels = [];
        if ($group->getParent) {
            if ($group->getParent->getAccessLevels) {
                foreach ($group->getParent->getAccessLevels as $accessLevel) {
                     foreach ($accessLevel->getPermissions as $permission) {
                        $parentPermissions[] = [$permission, $accessLevel->id];
                    }
                }
            }

            $groupParent = Group::getParentPermissions($group->getParent);
            $permissions = array_merge($parentPermissions, $groupParent);
            for ($i = 0; $i < count($permissions); $i++) {
                if (is_object($permissions[$i])) {
                    $permissions[$i] = [$permissions[$i], $permissions[$i]['access_level_id']];
                }
            }
        }

        return $permissions;
    }
/**
*
*@param parent id
*
*/
    public static function getParentPermissions($id) {
       $parent = Group::with(['getParent', 'getAccessLevels.getPermissions'])->find($id);
        $permissions = [];
        $permissionsG2 = [];
        if ($parent) {
            foreach ($parent->getAccessLevels as $accessLevel) {
                 foreach ($accessLevel->getPermissions as $permission) {
                    $permissions[] = $permission;
                }
       }

        }
return $permissions;
        
    }

    public  static function allPermissions($permissions, $parentPermissions){
        return array_merge($permissions, $parentPermissions);
    }

}
