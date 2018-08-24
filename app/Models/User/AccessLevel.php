<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class AccessLevel extends Model
{
	 /**
     * The table associated with the model.
     *
     * @var string
     */
   protected $table = 'access_levels';
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;




    public function userGroups()
    {
        return $this->belongsToMany('App\Models\User\Group', 'userGroup_accessLevels_map','access_level_id','user_group_id');
    }

}
