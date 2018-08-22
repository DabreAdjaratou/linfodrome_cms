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
}
