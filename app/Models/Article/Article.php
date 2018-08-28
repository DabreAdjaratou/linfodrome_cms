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

    public function getCategory()
    {
        return $this->belongsTo('App\Models\Article\Category','category_id');
    }

public function getAuteur()
    {
        return $this->belongsTo('App\Models\User\User','created_by');
    }
}
