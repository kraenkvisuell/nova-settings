<?php

namespace KraenkVisuell\NovaSettings\Tests;

use Illuminate\Support\Facades\Route;
use KraenkVisuell\NovaSettings\NovaSettings;
use KraenkVisuell\NovaSettings\NovaSettingsServiceProvider;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class IntegrationTestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();

        NovaSettings::clearFields();
        Route::middlewareGroup('nova', []);
        Nova::$tools = [
            new NovaSettings,
        ];

        $this->setUpDatabase($this->app);
    }

    protected function getPackageProviders($app)
    {
        return [
            NovaServiceProvider::class,
            NovaSettingsServiceProvider::class,
        ];
    }

    protected function setUpDatabase()
    {
        $this->artisan('migrate:fresh');
    }
}
