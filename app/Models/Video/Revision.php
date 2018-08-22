<?php

namespace App\Models\Video;

use Illuminate\Database\Eloquent\Model;

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
}
