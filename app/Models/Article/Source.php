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
        'title','published',
    ];


 public function getArticles()
    {
         return $this->hasMany('App\Models\Article\Article','source_id');
    }

    public function getArchives()
    {
         return $this->hasMany('App\Models\Article\Archive','source_id');
    }
}
