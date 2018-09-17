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

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','category_id','published','featured','image','code','description','created_by','cameraman','editor','created_at','start_publication_at','stop_publication_at','keywords',
    ];

    public function getCategory()
    {
        return $this->belongsTo('App\Models\Video\Category','category_id');
    }

   public function getAuthor()
    {
        return $this->belongsTo('App\Models\User\User','created_by');  
    }
      
        public function getEditor()
    {
        return $this->belongsTo('App\Models\User\User','editor');
    }

    public function getCameraman()
    {
        return $this->belongsTo('App\Models\User\User','cameraman');
    }

    

    public function getRevision()
    {
       return $this->hasMany('App\Models\Video\Revision','video_id');
    }
}
