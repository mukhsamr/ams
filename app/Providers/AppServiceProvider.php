<?php

namespace App\Providers;

use App\Models\Guardian;
use App\Models\User;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::defaultView('other.pagination');

        Gate::define('student', fn (User $user) => ($user->level == 1 || $user->level === '0'));
        Gate::define('teacher', fn (User $user) => ($user->level >= 2 || $user->level === '0'));
        Gate::define('guardian', fn (User $user) => ($user->level >= 3 || $user->level === '0') && Guardian::firstWhere('user_id', $user->id));
        Gate::define('operator', fn (User $user) => ($user->level >= 4 || $user->level === '0'));
        Gate::define('admin', fn (User $user) => ($user->level >= 5 || $user->level === '0'));
    }
}
