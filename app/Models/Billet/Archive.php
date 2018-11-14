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
     * Scope a query to only include billets whose creation date is between two  given date
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfBetweenTwoDate($query,$fromDate, $toDate)
    {
        return $query->whereBetween('created_at',[$fromDate,$toDate]);
    }   

    public  static function indexActions()
    {
      $actionTitles='<th>Brouillon</th><th>Corbeille</th>';
      $actions='<td><a href="'.route("billet-archives.put-in-draft",["billet"=>'billetId']) .'"><span class="uk-text-success">Mettre au brouillon</span></<a></td>
      <td> <a href="'.route('billet-archives.put-in-trash',['billet'=>'billetId']) .'" ><span class="uk-text-danger">Mettre en corbeille</span></a>
      </td>';
        return compact('actionTitles','actions');
    }

     public  static function trashActions()
    {
     $actionTitles='<th>Supprimer</th><th>Restaurer</th>';
      $actions='<td><form action="'. route("billet-archives.destroy",["billet"=>"billetId"]) . '" method="POST" id="deleteForm" >
                 <input type="hidden" name="_token" value="'.csrf_token().'">
                 <input type="hidden" name="_method" value="delete">
                <button class="uk-button uk-button-link"><span class="uk-text-success">Supprimer</span></button>
            </form></td>
      <td> <a href="'.route('billet-archives.restore',['billet'=>'billetId']) .'" ><span class="uk-text-danger">Restaurer</span></a>
      </td>';
        return compact('actionTitles','actions');
    }

     public  static function draftActions()
    {
      $actionTitles='<th>Modifier</th><th>Corbeille</th>';
      $actions='<td><a href="'.route("billet-archives.edit",["billet"=>'billetId']) .'"><span class="uk-text-success">modifié</span></<a></td>
      <td> <a href="'.route('billet-archives.put-in-trash',['billet'=>'billetId']) .'" ><span class="uk-text-danger">Corbeille</span></a>
      </td>';
        return compact('actionTitles','actions');
    }

}
