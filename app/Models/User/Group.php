<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
	 /**
     * The table associated with the model.
     *
     * @var string
     */
   protected $table = 'user_groups';

     
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
