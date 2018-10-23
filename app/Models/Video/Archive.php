<?php

namespace App\Models\Video;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Archive extends Model
{
    use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];
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


/**
 * Fetch videos with condition in the datatables.
 *
 * @param \Illuminate\Database\Eloquent\Builder
 * @param \Illuminate\Database\Eloquent\Builder
 */
public static function laratablesQueryConditions($query)
{
    return $query->where('published', '<>',2)->orderBy('id','desc');
}
/**
 * Eager load user items of the archive for displaying in the datatables.
 *
 * @return callable
 */
public static function laratablesGetRevisionRelationQuery()
{
    return function ($query) {
        $query->with('getModifier');
    };
}

    /**
     * Returns the edit action column  html for datatables.
     *
     * @param \App\Models\Video\Video
     * @return string
     */
public static function laratablesCustomEdit($archive)
    {
        return view('video.archives.administrator.laratableCustumColumns.edit',compact('archive'))->render();
    }
   /* *
     * Returns the put in trash action column html for datatables.
     *
     * @param \App\Models\Video\Video
     * @return string
     */
public static function laratablesCustomTrash($archive)
    {
        return view('video.archives.administrator.laratableCustumColumns.trash',compact('archive'))->render();
    }

    /* *
     * Returns the  put in draft action column html for datatables.
     *
     * @param \App\Models\Video\Video
     * @return string
     */
public static function laratablesCustomDraft($archive)
    {
        return view('video.archives.administrator.laratableCustumColumns.draft',compact('archive'))->render();
    }

    /* *
     * Returns clikable title  for datatables.
     *
     * * @return string
     */
public function laratablesTitle()
{
    return "<a href=".route("video-archives.edit",["archive"=>$this->id]).">".$this->title."</a>";
}
 }
