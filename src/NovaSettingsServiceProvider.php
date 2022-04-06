<?php

namespace KraenkVisuell\NovaSettings;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use KraenkVisuell\NovaSettings\Http\Middleware\Authorize;
use KraenkVisuell\NovaSettings\Http\Middleware\SettingsPathExists;

class NovaSettingsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'nova-settings');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        if ($this->app->runningInConsole()) {
            // Publish migrations
            $this->publishes([
                __DIR__.'/../database/migrations' => database_path('migrations'),
            ], 'migrations');

            // Publish config
            $this->publishes([
                __DIR__.'/../config/' => config_path(),
            ], 'config');
        }
    }

    public function register()
    {
        $this->registerRoutes();

        $this->mergeConfigFrom(
            __DIR__.'/../config/nova-settings.php',
            'nova-settings'
        );

        $this->app->singleton(NovaSettingsStore::class, function () {
            return new NovaSettingsStore();
        });
    }

    protected function registerRoutes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class, SettingsPathExists::class])
            ->group(__DIR__.'/../routes/api.php');
    }
}
