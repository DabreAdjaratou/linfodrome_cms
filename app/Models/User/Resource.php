<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\Action;

class Resource extends Model
{
   
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];

    public function getActions() {
        return $this->belongsToMany('App\Models\User\Action', 'resource_action_map',  'resource_id','action_id');
    }
}
