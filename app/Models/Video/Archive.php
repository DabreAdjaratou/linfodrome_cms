<?php

namespace App\Models\Video;

use Illuminate\Database\Eloquent\Model;

class Archive extends Model
{
	 /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'video_archives';

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
}
