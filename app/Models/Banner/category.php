<?php

namespace App\Models\Banner;

use Illuminate\Database\Eloquent\Model;

class category extends Model
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'banner_categories';

   
   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','published',
    ];
     public function getBanners()
    {
         return $this->hasMany('App\Models\Banner\Banner','category_id');
    }
}
