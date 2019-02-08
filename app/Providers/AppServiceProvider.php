<?php

namespace App\Providers;

use App\Access;
use App\Libs\Datamap;
use App\Observers\AccessObserver;
use App\Observers\PeriodObserver;
use App\Observers\UserObserver;
use App\Period;
use App\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Access::observe(AccessObserver::class);
        Period::observe(PeriodObserver::class);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Datamap::class, function ($app) {
            return new Datamap();
        });

        if ($this->app->environment() !== 'production') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    public function provides()
    {
        return [
            Datamap::class,
        ];
    }
}
