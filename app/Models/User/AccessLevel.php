<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\Group;

class AccessLevel extends Model
{
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


    public static function getGoup($id) {
        return Group::find($id);
    }

public function getPermission() {
        return $this->hasMany('App\Models\User\Permission', 'permissions', 'access_level_id');
    }

}
