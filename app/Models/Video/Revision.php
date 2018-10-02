<?php

namespace App\Models\Video;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Revision extends Model
{
	 /**
     * The table associated with the model.
     *
     * @var string
     */
   protected $table = 'revision_videos';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

     public function getModifier()
    {
       return $this->belongsTo('App\Models\User\User','user_id');
    }

     public function getVideo()
    {
       return $this->belongsTo('App\Models\Video\Archive','video_id')->withTrashed();
    }

}
