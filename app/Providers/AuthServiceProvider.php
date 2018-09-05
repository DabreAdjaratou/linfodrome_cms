<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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


    }
}
