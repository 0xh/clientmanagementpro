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
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('toggle-clonable', function ($user,$project) {
            if(get_class($user) === 'App\User'){
                return true;
            }
            return $project->tenant_id === $user->id;
        });

        Gate::define('clone-project', function ($user,$project) {
            if(get_class($user) === 'App\User'){
                return true;
            }
            return $project->tenant_id === $user->id;
            
        });

        Gate::define('manage-projects', function ($user,$tenant) {
            if(get_class($user) === 'App\User'){
                return true;
            }
            return $tenant->id === $user->id;
            
        });

    }
}
