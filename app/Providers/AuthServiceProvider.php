<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        if (! $this->app->routesAreCached()) {
            Passport::routes();
        }
        Gate::define('isSuperAdmin',function($user){
            return $user->role == 'superadmin';
        });

        Gate::define('isAdmin',function($user){
            return $user->role == 'admin'; 
        });

        Gate::define('isSuperAdminOrAdmin',function($user){
            return $user->role == 'superadmin' && 'admin';
        });        

        Gate::define('isDoc',function($user){
            return $user->role == 'doctor';
        });

        Gate::define('isNurse',function($user){
            return $user->role == 'nurse';
        });

        Gate::define('isAccountant',function($user){
            return $user->role == 'accountant';
        });

        Gate::define('isPharm',function($user){
            return $user->role == 'pharmacist';
        });

        Gate::define('isStaff',function($user){
            return $user->role == 'staff';
        });
    }
}
