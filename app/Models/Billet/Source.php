<?php

namespace App\Models\Billet;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Source extends Model
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
    protected $table = 'billet_sources';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','published',
    ];

/**
* get billets list for a source
*@param
*@return collection of items
*
*/
 public function getBillets()
    {
         return $this->hasMany('App\Models\Billet\Billet','source_id');
    }
/**
* get articles list for a source
*@param
*@return collection of items
*
*/
    public function getArchives()
    {
         return $this->hasMany('App\Models\Billet\Archive','source_id');
    }
    
}
