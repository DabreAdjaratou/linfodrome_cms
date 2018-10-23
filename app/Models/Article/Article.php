<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
     use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
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
        'ontitle','title','category_id','published','featured','image','image_legend','video','gallery_photo','introtext','fulltext','source_id','keywords','created_by','created_at','checkout','start_publication_at','stop_publication_at',
    ];

   public function getCategory()
    {
        return $this->belongsTo('App\Models\Article\Category','category_id');
    }

   public function getAuthor()
    {
        return $this->belongsTo('App\Models\User\User','created_by');
    }

    public function getRevision()
    {
       return $this->hasMany('App\Models\Article\Revision','article_id');
    }
    
    /**
 * Fetch articles with condition in the datatables.
 *
 * @param \Illuminate\Database\Eloquent\Builder
 * @param \Illuminate\Database\Eloquent\Builder
 */
public static function laratablesQueryConditions($query)
{
    return $query->where('published', '<>',2)->orderBy('id','desc');
}
/**
 * Eager load revision item for displaying in the datatables.
 *
 * @return callable
 */
public static function laratablesGetRevisionRelationQuery()
{
    return function ($query) {
        $query->with('getModifier');
    };
}
  /**
     * Returns the edit action column  html for datatables.
     *
     * @param \App\Models\Article\Article
     * @return string
     */
public static function laratablesCustomEdit($article)
    {
        return view('article.articles.administrator.laratableCustumColumns.edit',compact('article'))->render();
    }
   /* *
     * Returns the put in trash action column html for datatables.
     *
     * @param \App\Models\Article\Article
     * @return string
     */
public static function laratablesCustomTrash($article)
    {
        return view('article.articles.administrator.laratableCustumColumns.trash',compact('article'))->render();
    }

    /* *
     * Returns the  put in draft action column html for datatables.
     *
     * @param \App\Models\Article\Article
     * @return string
     */
public static function laratablesCustomDraft($article)
    {
        return view('article.articles.administrator.laratableCustumColumns.draft',compact('article'))->render();
    }
 /* *
     * Returns the last updated by column html for datatables.
     *
     * @param \App\Models\Article\Article
     * @return string
     */
public static function laratablesCustomLastUpdatedBy($article)
    {
        return view('article.articles.administrator.laratableCustumColumns.lastUpdatedBy',compact('article'))->render();
    }
    /* *
     * Returns the last updated at column html for datatables.
     *
     * @param \App\Models\Article\Article
     * @return string
     */
public static function laratablesCustomLastUpdatedAt($article)
    {
        return view('article.articles.administrator.laratableCustumColumns.lastUpdatedAt',compact('article'))->render();
    }


 /* *
     * Returns clikable title  for datatables.
     *
     * * @return string
     */
public function laratablesTitle()
{
    return "<a href=".route("articles.edit",["article"=>$this->id]).">".$this->title."</a>";
}

    
}
