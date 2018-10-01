<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\Action;
use Illuminate\Database\Eloquent\SoftDeletes;

class Resource extends Model
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
        'title',
    ];

    public function getActions() {
        return $this->belongsToMany('App\Models\User\Action', 'resource_action_map',  'resource_id','action_id');
    }
    public function getPermissions() {
        return $this->hasMany('App\Models\User\Permission', 'resource_id');
    }
}
