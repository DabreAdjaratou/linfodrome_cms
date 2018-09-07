<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;
use App\Models\User\AccessLevel;

class Group extends Model
{
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
    
    public function getChildrens()
    {
        return $this->hasMany('App\Models\User\Group', 'parent_id');
    }

   public function getAccessLevels()
    {

//      $groups2 = Group::all();
//      $accessLevels=AccessLevel::all();
//         foreach ($groups2 as $g) {
//         //     $g->title= ucfirst($g->title);
//         //   foreach ($g->getChildrens as $g2) {
             
//         //       foreach ($g2->getChildrens as $g3) {
//         //          echo $g3;
//         //   }

        
//         // }

// foreach ($accessLevels as $key=> $a) {
//     $accessGroups=json_decode($a->groups);
//     $array=[];
// for ($i=0; $i <count($accessGroups) ; $i++) { 
//  if ($accessGroups[$i]==$g->id){
// $array['id']=$a->title;
//  }
// // $array2=array_merge($array);
     
// }
//         }
// print_r($array);
//     }   
//         echo'<pre>';     

//         echo'</pre>';     
    } 
    
//     Return $accessLevels;
}
