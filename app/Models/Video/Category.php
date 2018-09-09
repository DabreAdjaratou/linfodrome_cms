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
        'title',
    ];
}
