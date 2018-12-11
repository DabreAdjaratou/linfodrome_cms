<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Action extends Model
{
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
        'title','display_name',
    ];

/**
* get ressources that belongs to an action
*@param
*@return collection of items
*
*/
    public function getResources()
    {
        return $this->belongsToMany('App\Models\User\Resource', 'resource_action_map', 'action_id', 'resource_id');
    }

/**
* get permissions that belongs to an action
*@param
*@return collection of items
*
*/
    public function getPermissions()
    {
        return $this->hasMany('App\Models\User\Permission', 'action_id');
    }


	
}
