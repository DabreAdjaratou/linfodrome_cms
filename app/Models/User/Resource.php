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

    public function getActions() {
    // return $this->hasManyThrough(
    //         'App\Models\User\Action',
    //         'App\Models\User\Permission',
    //         'action_id', // Foreign key on users table...
    //         'permission_id', // Foreign key on posts table...
    //         'id', // Local key on countries table...
    //         'id' // Local key on users table..
    //     );
    }
}
