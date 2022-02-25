<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

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

        Gate::define('student', fn (User $user) => ($user->level == 1 || $user->level === '0'));
        Gate::define('teacher', fn (User $user) => ($user->level >= 2 || $user->level === '0'));
        Gate::define('guardian', fn (User $user) => ($user->level >= 3 || $user->level === '0') && $user->guardian);
        Gate::define('operator', fn (User $user) => ($user->level >= 4 || $user->level === '0'));
        Gate::define('admin', fn (User $user) => ($user->level >= 5 || $user->level === '0'));
    }
}
