<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
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
        'title',
    ];

}
