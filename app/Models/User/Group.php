<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\AccessLevel;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
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
   protected $table = 'user_groups';

     
  /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','parent_id',
    ]; 
    

    public function getChildren()
    {
        return $this->hasMany('App\Models\User\Group', 'parent_id');
    }

    public function getParent()
    {
        return $this->belongsTo('App\Models\User\Group', 'parent_id');
    }

    
    Public function getAccessLevels(){
    return $this->belongsToMany('App\Models\User\Accesslevel', 'usergroup_accesslevel_map','user_group_id');
    }

    public static function getPermissions($id){
    $group=Group::with(['getParent','getAccessLevels.getPermissions'])->find($id);
$permissions=[];
foreach ($group->getAccessLevels as $a) {
  foreach ($a->getPermissions as $p) {
              $permissions[]=$p;
            }
}

if ($group->getParent){
   $p=Group::getParentPermissions($group->getParent);
   $permissions=array_merge($permissions,$p);
   // dd($permissions);
          // foreach ($group->getParent->getAccessLevels as $a) {
          // print_r($a->getPermissions->toArray());
        // }
    // }
// dd(($permissions));
}
return $permissions;
}

    public static function getParentPermissions(Group $group){
        $parent=Group::with(['getParent','getAccessLevels.getPermissions'])->find($group->parent_id);
           $permissions=[];
           $t=[];
           if($parent){
        foreach ($parent->getAccessLevels as $a) {
        // if($a->getPermissions){
           // echo $a->getPermissions->count().'<br>';
            foreach ($a->getPermissions as $p) {
              $permissions[]=$p;
            }
        // echo $a->title;
        }
  
      // print_r(count($permissions));
        if($parent->getParent){
      $t=Group::getPermissions($parent->getParent->id);
        }
           }
        // echo 'total:';
        return array_merge($permissions,$t);
    }

   
}