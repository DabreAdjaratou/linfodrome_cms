<?php

namespace App\Models\Billet;

use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
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


 public function getBillets()
    {
         return $this->hasMany('App\Models\Billet\Billet','source_id');
    }

    public function getArchives()
    {
         return $this->hasMany('App\Models\Billet\Archive','source_id');
    }
    
}
