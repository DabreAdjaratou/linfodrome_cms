<?php

namespace App\Models\Video;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
	 /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'video_categories';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','published',
    ];

      public function getVideos()
    {
         return $this->hasMany('App\Models\Video\Video','category_id');
    }

    public function getArchives()
    {
         return $this->hasMany('App\Models\Video\Archive','category_id');
    }
}
