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

/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','parent_id',
    ]; 
    
    public function getChildrens()
    {
        return $this->hasMany('App\Models\User\Group', 'parent_id');
    }
    
    
}
