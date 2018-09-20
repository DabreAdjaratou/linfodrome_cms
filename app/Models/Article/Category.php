<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'article_categories';

   
   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','published',
    ];

     public function getArticles()
    {
         return $this->hasMany('App\Models\Article\Article','category_id');
    }

    public function getArchives()
    {
         return $this->hasMany('App\Models\Article\Archive','category_id');
    }

}