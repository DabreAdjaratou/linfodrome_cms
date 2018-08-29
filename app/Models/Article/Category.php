<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'article_categories';

    
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