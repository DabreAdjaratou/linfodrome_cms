<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
       
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','display_name',
    ];

}
