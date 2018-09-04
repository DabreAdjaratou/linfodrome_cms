<?php

namespace App\Models\Billet;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
   /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'billet_categories';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];
}
