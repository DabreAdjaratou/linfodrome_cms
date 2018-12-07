<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
use SoftDeletes;
/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

/**
*get permission's action
*@param
*@return item collection
*
**/
public function getAction(){

return $this->belongsTo('App\Models\User\Action', 'action_id');
}    
/**
*get permission's access level
*@param
*@return item collection
*
**/
public function getAccessLevel(){

return $this->belongsTo('App\Models\User\AccessLevel', 'access_level_id');
	
}

/**
*get permission's resource
*@param
*@return item collection
*
**/
public function getResource(){

return $this->belongsTo('App\Models\User\Resource', 'resource_id');
	
}
}
