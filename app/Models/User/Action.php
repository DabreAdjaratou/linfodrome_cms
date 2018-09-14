<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
       
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','display_name',
    ];

    public function getResources()
    {
        return $this->belongsToMany('App\Models\User\Resource', 'resource_action_map', 'action_id', 'resource_id');
    }


	
}
