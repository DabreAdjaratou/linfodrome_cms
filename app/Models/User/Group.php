<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\AccessLevel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
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
   protected $table = 'user_groups';

     
  /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','parent_id',
    ]; 
    

    public function getChildren()
    {
        return $this->hasMany('App\Models\User\Group', 'parent_id');
    }

    public function getParent()
    {
        return $this->belongsTo('App\Models\User\Group', 'parent_id');
    }

    
    Public function getAccessLevels(){
    return $this->belongsToMany('App\Models\User\Accesslevel', 'usergroup_accesslevel_map','user_group_id');
    }
   
}