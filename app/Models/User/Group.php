<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\AccessLevel;

class Group extends Model
{
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
        'title','parent_id',
    ]; 
    

    public function getChildrens()
    {
        return $this->hasMany('App\Models\User\Group', 'parent_id');
    }

    public function getParents()
    {
        return $this->belongsTo('App\Models\User\Group', 'parent_id');
    }

    
    Public function getAccessLevels(){
    return $this->belongsToMany('App\Models\User\Accesslevel', 'usergroup_accesslevel_map','user_group_id');
    }
   
}