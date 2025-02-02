<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use App\Http\Middleware\CheckWildcardPermission;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Gate;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(Router $router): void
    {
        //
        Gate::before(function ($user, $ability) {
            return $user->hasRole('admin') ? true : null;
        });

        $router->aliasMiddleware('wildcard.permission', CheckWildcardPermission::class);

    }
}
