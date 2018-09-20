<?php

namespace App\Models\Billet;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Billet extends Model
{
	use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];     
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
        'ontitle','title','category_id','published','featured','image','image_legend','video','gallery_photo','introtext','fulltext','source_id','keywords','created_by','created_at','start_publication_at','stop_publication_at',
    ];
     
     public function getCategory()
    {
        return $this->belongsTo('App\Models\Billet\Category','category_id');
    }

   public function getAuthor()
    {
        return $this->belongsTo('App\Models\User\User','created_by');
    }

    public function getRevision()
    {
       return $this->hasMany('App\Models\Billet\Revision','billet_id');
    }

    public function getSource()
    {
        return $this->belongsTo('App\Models\Billet\Source','source_id');
    }

}
