<?php

namespace App\Models\Video;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
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
        'title','category_id','published','featured','image','code','description','created_by','data','created_at','start_publication_at','stop_publication_at','keywords',
    ];
    
     public function getCategory()
    {
        return $this->belongsTo('App\Models\Video\Category','category_id');
    }

   public function getAuthor()
    {
        return $this->belongsTo('App\Models\User\User','created_by');
    }

    public function getRevision()
    {
       return $this->hasMany('App\Models\Video\Revision','video_id');
    }
}