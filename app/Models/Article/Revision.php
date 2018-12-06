<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'revision_articles';
      
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
        'type','user_id','article_id','revised_at',
    ];
/**
* get the modifier
*@param
*@return collection of items
*
*/
    public function getModifier()
    {
       return $this->belongsTo('App\Models\User\User','user_id');
    }
/**
* get the item concerned by the modification
*@param
*@return collection of items
*
*/
     public function getArticle()
    {
       return $this->belongsTo('App\Models\Article\Archive','article_id')->withTrashed();
    }


 
}