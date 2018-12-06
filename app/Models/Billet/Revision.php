<?php

namespace App\Models\Billet;

use Illuminate\Database\Eloquent\Model;

class Revision extends Model
{
	 /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'revision_billets';
  
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
/**
* get the modifier
*@param
*@return collection of items
*
*/
 public function getModifier()
    {
       return $this->belongsTo('App\Models\User\User','user_id');
    }
/**
* get the item concerned by the modification
*@param
*@return collection of items
*
*/
public function getBillet()
    {
       return $this->belongsTo('App\Models\Billet\Archive','billet_id')->withTrashed();
    }
}
