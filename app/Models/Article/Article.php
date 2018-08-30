<?php

namespace App\Models\Article;

use Illuminate\Database\Eloquent\Model;


class Article extends Model
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
        'ontitle','title','category_id','published','featured','image','image_legend','video','gallery_photo','introtext','fulltext','source_id','keywords','created_by','created_at','start_publication_at','stop_publication_at',
    ];

   
    

    
}
