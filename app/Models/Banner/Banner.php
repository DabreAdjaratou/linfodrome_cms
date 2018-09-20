<?php

namespace App\Models\Banner;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
	use SoftDeletes;
	/**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'title','published','category_id','type','image','size','url','code','start_publication_at','stop_publication_at','created_by','created_at','updated_at'
    ];
			
     public function getCategory()
    {
         return $this->belongsTo('App\Models\Banner\Category','category_id');
    }

     public function getAuthor()
    {
        return $this->belongsTo('App\Models\User\User','created_by');
    }
}
