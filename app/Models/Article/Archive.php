<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'article_archives';

    /**
     * Indicates it is a non-incrementing primary key.
     *
     * @var bool
     */
    public  $incrementing= false;
    
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
        'ontitle','title','category_id','published','featured','image','image_legend','video','gallery_photo','introtext','fulltext','source_id','keywords','created_by','created_at','start_publication_at','stop_publication_at',
    ];

    public function getCategory()
    {
        return $this->belongsTo('App\Models\Article\Category','category_id');
    }

   public function getAutor()
    {
        return $this->belongsTo('App\Models\User\User','created_by');
    }

    public function getRevision()
    {
       return $this->hasMany('App\Models\Article\Revision');
    }


}