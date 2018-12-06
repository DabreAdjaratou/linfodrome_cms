<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\Group;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccessLevel extends Model
{
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
   protected $table = 'access_levels';
    
   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'title', 
    ];

/**
* get the list groups that belong to a access level and vice versa
*@param
*@return collection of items
*
*/
public function getGroups() {
        return $this->belongsToMany('App\Models\User\Group', 'usergroup_accesslevel_map',  'access_level_id','user_group_id');
    }
/**
* get permissions of a access level
*@param
*@return collection of items
*
*/
public function getPermissions() {
        return $this->hasMany('App\Models\User\Permission', 'access_level_id');
    }

}
