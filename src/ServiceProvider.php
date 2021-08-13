<?php

namespace ChrisBraybrooke\S3DirectUpload;

use ChrisBraybrooke\S3DirectUpload\Providers\EventServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Illuminate\FileSystem\FileSystem;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the package.
     *
     * @return void
     */
    public function boot()
    {
        $this->handleRoutes();
        $this->handleConfigs();
        $this->handleMigrations();
        $this->handleTranslations();


        if ($this->app->runningInConsole()) {
            $this->commands([
                //
            ]);
        }
    }

    /**
     * Register anything this package needs.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfig();

        $this->app->register(EventServiceProvider::class);
    }

    /** 
     * Register any migrations.
     *
     * @return void
     */
    private function handleMigrations()
    {
        if (!config('s3directupload.ignore_migrations')) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');            
        }

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 's3-direct-upload-migrations');
    }

    /** 
     * Register any translations.
     *
     * @return void
     */
    private function handleTranslations()
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 's3-direct-upload');

        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/s3-direct-upload'),
        ], 's3-direct-upload-translations');
    }

    /** 
     * Merge the config files from both the package and application.
     *
     * @return void
     */
    private function mergeConfig()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/s3directupload.php', 's3directupload'
        );
    }

    /** 
     * Register any config files this package needs.
     *
     * @return void
     */
    private function handleConfigs()
    {
        $this->publishes([
            __DIR__.'/../config/s3directupload.php' => config_path('s3directupload.php')
        ], 's3-direct-upload-config');
    }

    /** 
     * Register any routes this package needs.
     *
     * @return void
     */
    private function handleRoutes()
    {
        Route::group([
            'name' => 's3-direct-upload-web',
            'namespace' => 'ChrisBraybrooke\S3DirectUpload\Http\Controllers',
            'middleware' => ['web']
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });

        Route::group([
            'name' => 's3-direct-upload-web',
            'prefix' => 'api',
            'namespace' => 'ChrisBraybrooke\S3DirectUpload\Http\Controllers\Api',
            'middleware' => ['api']
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        });
    }
}
