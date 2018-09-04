<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\Action;

class Resource extends Model
{
   
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];

    public static function getAction($id) {
        return Action::find($id);
    }
}
