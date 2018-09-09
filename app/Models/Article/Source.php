<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'article_sources';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];

}
