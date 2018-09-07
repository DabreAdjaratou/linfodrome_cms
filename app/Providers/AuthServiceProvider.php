<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User\AccessLevel;
use App\Models\User\User;
use lluminate\Support\Collection;

use Illuminate\Support\Facades\Auth;
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        'App\Models\Article\Archive' =>'App\Policies\Article\ArchivePolicy',
        'App\Models\Article\Article' =>'App\Policies\Article\ArticlePolicy',
        'App\Models\Article\Category' =>'App\Policies\Article\CategoryPolicy',
        'App\Models\Article\Revision' =>'App\Policies\Article\RevisionPolicy',
        'App\Models\Article\Source' =>'App\Policies\Article\SourcePolicy',
       
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
//         $user= User::with('getGroups:title')->where('id',1)->get(['id','name']);
//         $user= $user->toArray();
//         $userGroups=$user[0]['get_groups'];
       
//         for ($i=0; $i <count($userGroups) ; $i++) { 

//           $r[]=$userGroups[$i]['pivot']['user_group_id'];
//         }
// $r=collect($r);
//         echo '<pre>';
//         // print_r($r);
//         echo '</pre>';
// $accessLevels= AccessLevel::all();
// for ($i=0; $i <count($r) ; $i++) { 
//    foreach ($accessLevels as $key => $a) {
//     $accessGroups=json_decode($a->groups);
//     $e=$r->intersect($accessGroups);
//     $all=collect($e->all());
//         echo '<pre>';
//         print_r();
//         echo '</pre>';

// }
// }


    }
}
