<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{


public function getAction(){

return $this->belongsTo('App\Models\User\Action', 'action_id');
}    //

public function getAccessLevel(){

return $this->belongsTo('App\Models\User\AccessLevel', 'access_level_id');
	
}

public function getResource(){

return $this->belongsTo('App\Models\User\Resource', 'resource_id');
	
}
}
