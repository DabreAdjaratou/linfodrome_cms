<?php

namespace App\Models\Billet;

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
   protected $table = 'billet_archives';
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
    /**
 * Fetch  billets with condition in the datatables.
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
     * @param \App\Models\Billet\Archive
     * @return string
     */
public static function laratablesCustomEdit($archive)
    {
        return view('billet.archives.administrator.laratableCustumColumns.edit',compact('archive'))->render();
    }
   /* *
     * Returns the put in trash action column html for datatables.
     *
     * @param \App\Models\Billet\Archive
     * @return string
     */
public static function laratablesCustomTrash($archive)
    {
        return view('billet.archives.administrator.laratableCustumColumns.trash',compact('archive'))->render();
    }

    /* *
     * Returns the  put in draft action column html for datatables.
     *
     * @param \App\Models\Billet\Archive
     * @return string
     */
public static function laratablesCustomDraft($archive)
    {
        return view('billet.archives.administrator.laratableCustumColumns.draft',compact('archive'))->render();
    }
 /* *
     * Returns the last updated by column html for datatables.
     *
     * @param \App\Models\Billet\Archive
     * @return string
     */
public static function laratablesCustomLastUpdatedBy($archive)
    {
        return view('billet.archives.administrator.laratableCustumColumns.lastUpdatedBy',compact('archive'))->render();
    }
    /* *
     * Returns the ast updated at column html for datatables.
     *
     * @param \App\Models\Billet\Archive
     * @return string
     */
public static function laratablesCustomLastUpdatedAt($archive)
    {
        return view('billet.archives.administrator.laratableCustumColumns.lastUpdatedAt',compact('archive'))->render();
    }


/* *
     * Returns clikable title  for datatables.
     *
     * * @return string
     */
public function laratablesTitle()
{
    return "<a href=".route("billet-archives.edit",["archive"=>$this->id]).">".$this->title."</a>";
}

}
