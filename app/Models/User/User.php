<?php

namespace App\Models\User;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','image','is_active','require_reset','data',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


public function getGroups()
    {
        return $this->belongsToMany('App\Models\User\Group', 'user_usergroup_map', 'user_id', 'user_group_id');
    }

    
}
