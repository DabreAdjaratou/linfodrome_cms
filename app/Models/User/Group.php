<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\AccessLevel;
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

    public function getChildren() {
        return $this->hasMany('App\Models\User\Group', 'parent_id');
    }

    public function getParent() {
        return $this->belongsTo('App\Models\User\Group', 'parent_id');
    }

    Public function getAccessLevels() {
        return $this->belongsToMany('App\Models\User\AccessLevel', 'usergroup_accesslevel_map', 'user_group_id');
    }

     Public function getUsers() {
        return $this->belongsToMany('App\Models\User\User', 'user_usergroup_map', 'user_group_id');
    }

/**
     * get permissions for the specify group. 
     *the group permissions is the set of permissions of all access levels that group and  it parent belong's to
     *
     * @return \Illuminate\Http\Response
     */
    public static function getPermissions($id) {
        $group = Group::with(['getParent', 'getAccessLevels.getPermissions'])->find($id);
        $permissions = [];
        $Allpermissions=[];
        // get group own permissions via its access levels
        foreach ($group->getAccessLevels as $accessLevel) {
            foreach ($accessLevel->getPermissions as $permission) {
                $permissions[] = $permission;
            }
        }
// if the group has a prarent, get parent permissions and merge with group permissions and return all permissions
        if ($group->getParent) {
            $parentPermissions = Group::getParentPermissions($group->getParent);
            $Allpermissions = array_merge($permissions, $parentPermissions);
        return $Allpermissions;
        }
        return $permissions;

    }

/**
     * get permissions for the specify group if that group doesn't belong to any access level.
     * in this case the group inherit of it parent permissions
     * @return \Illuminate\Http\Response
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

    public static function getParentPermissions(Group $group) {
        $parent = Group::with(['getParent', 'getAccessLevels.getPermissions'])->find($group->parent_id);
        $permissions = [];
        $permissionsG2 = [];
        if ($parent) {
            foreach ($parent->getAccessLevels as $accessLevel) {
                 foreach ($accessLevel->getPermissions as $permission) {
                    $permissions[] = $permission;
                }
                            }

            if ($parent->getParent) {
                $permissionsG2 = Group::getPermissions($parent->getParent->id);
            }
        }
        return array_merge($permissions, $permissionsG2);
    }

}
