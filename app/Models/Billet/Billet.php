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
    
/**
 * Fetch billets with condition in the datatables.
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
     * @param \App\Models\Billet\Billet
     * @return string
     */
public static function laratablesCustomEdit($billet)
    {
        return view('billet.billets.administrator.laratableCustumColumns.edit',compact('billet'))->render();
    }
   /* *
     * Returns the put in trash action column html for datatables.
     *
     * @param \App\Models\Billet\Billet
     * @return string
     */
public static function laratablesCustomTrash($billet)
    {
        return view('billet.billets.administrator.laratableCustumColumns.trash',compact('billet'))->render();
    }

    /* *
     * Returns the  put in draft action column html for datatables.
     *
     * @param \App\Models\Billet\Billet
     * @return string
     */
public static function laratablesCustomDraft($billet)
    {
        return view('billet.billets.administrator.laratableCustumColumns.draft',compact('billet'))->render();
    }
 /* *
     * Returns the last updated by column html for datatables.
     *
     * @param \App\Models\Billet\Billet
     * @return string
     */
public static function laratablesCustomLastUpdatedBy($billet)
    {
        return view('billet.billets.administrator.laratableCustumColumns.lastUpdatedBy',compact('billet'))->render();
    }
    /* *
     * Returns the ast updated at column html for datatables.
     *
     * @param \App\Models\Billet\Billet
     * @return string
     */
public static function laratablesCustomLastUpdatedAt($billet)
    {
        return view('billet.billets.administrator.laratableCustumColumns.lastUpdatedAt',compact('billet'))->render();
    }

/* *
     * Returns clikable title  for datatables.
     *
     * * @return string
     */
public function laratablesTitle()
{
    return "<a href=".route("billets.edit",["billet"=>$this->id]).">".$this->title."</a>";
}
}
