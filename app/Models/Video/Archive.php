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
     * Scope a query to only include articles that match to  a given title.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfTitle($query, $title)
    {
        return $query->where('title','like', '%'.$title.'%');
    }  
 /**
     * Scope a query to only include articles that match to  a given category.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfCategory($query, $category)
    {
        return $query->where('category_id', $category);
    }   
    
    /**
     * Scope a query to only include articles that match to  a given featured state.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfFeaturedState($query, $featuredState)
    {
        if($featuredState==1){
        return $query->where('featured', $featuredState);
        }else{
        return $query->where('featured','<>',1);
        }
    }   
    
    /**
     * Scope a query to only include articles that match to  a given published state.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfPublishedState($query, $publishedState)
    {
        
if($publishedState==1){
        return $query->where('published', $publishedState);
       }else{
        return $query->where('published','<>',1);
        }  
 }   
    /**
     * Scope a query to only include articles that match to  a given author.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfUser($query, $user)
    {
        return $query->where('created_by', $user);
    }   

    
    /**
     * Scope a query to only include articles whose creation date is more than a given date
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfFromDate($query, $fromDate)
    {
        return $query->where('created_at', '>=',$fromDate);
    }   


     /**
     * Scope a query to only include articles whose creation date is less than a given date
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfToDate($query, $toDate)
    {
        return $query->where('created_at', '<=',$toDate);
    } 

     /**
     * Scope a query to only include articles whose creation date is between two  given date
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfBetweenTwoDate($query,$fromDate, $toDate)
    {
        return $query->whereBetween('created_at',[$fromDate,$toDate]);
    }    
 }
