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


     public function getModifier()
    {
       return $this->belongsTo('App\Models\User\User','user_id');
    }

}
