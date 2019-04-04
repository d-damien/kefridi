<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

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

        // seulement les jetons personnels
        Passport::routes(function($router) {
            $router->forPersonalAccessTokens();
        });

        Gate::define('task', function($user, $task) {
            if (! $task)
                return false;
            return $user->id == $task->user_id;
        });
    }
}
