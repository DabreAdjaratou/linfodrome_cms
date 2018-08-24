<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
	 /**
     * The table associated with the model.
     *
     * @var string
     */
   protected $table = 'user_groups';

     
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


    public function parent()
    {
        return $this->belongsTo('App\Models\User\Group', 'parent_id');
    }


     public function accessLevels()
    {
        return $this->belongsToMany('App\Models\User\AccessLevel');
    }
}
