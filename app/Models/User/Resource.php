<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
   
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


    public function actions()
    {
        return $this->hasMany('App\Models\User\Action', 'actions');
    }
}
