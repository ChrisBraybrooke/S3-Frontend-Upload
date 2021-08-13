<?php

namespace ChrisBraybrooke\Helpers;

use ChrisBraybrooke\Helpers\Commands\AttachRoleToUser;
use ChrisBraybrooke\Helpers\Commands\CreateApiToken;
use ChrisBraybrooke\Helpers\Commands\CreateUser;
use ChrisBraybrooke\Helpers\Commands\MakeAction;
use ChrisBraybrooke\Helpers\Commands\MakeModelResource;
use ChrisBraybrooke\Helpers\Commands\MakeTrait;
use ChrisBraybrooke\Helpers\Commands\PublishCustomStubs;
use ChrisBraybrooke\Helpers\Commands\SyncPermissions;
use ChrisBraybrooke\Helpers\Providers\EventServiceProvider;
use ChrisBraybrooke\Helpers\Providers\MacroServiceProvider;
use Illuminate\FileSystem\FileSystem;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;

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

        if (env('APP_ENV') === 'local') {
            $this->handleMigrations();
        }

        if ($this->app->runningInConsole()) {
            $this->commands([
                CreateUser::class,
                AttachRoleToUser::class,
                MakeModelResource::class,
                SyncPermissions::class,
                CreateApiToken::class,
                MakeTrait::class,
                MakeAction::class,
                PublishCustomStubs::class,
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
        $this->mergeConfigFrom(
            __DIR__.'/../config/helpers.php', 'helpers'
        );

        $this->app->register(EventServiceProvider::class);
        $this->app->register(MacroServiceProvider::class);
    }

    /** 
     * Register any migrations.
     *
     * @return void
     */
    private function handleMigrations()
    {
        $this->publishes([
            __DIR__.'/../database/migrations/default.php.stub' => database_path('migrations/2020_03_15_000000_default.php')
        ], 'helpers-migrations');
    }

    /** 
     * Register any routes this package needs.
     *
     * @return void
     */
    private function handleRoutes()
    {
        Route::group([
            'name' => 'helpers',
            'namespace' => 'ChrisBraybrooke\Helpers\Http\Controllers',
            'middleware' => ['web']
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });
    }

    /** 
     * Register any config files this package needs.
     *
     * @return void
     */
    private function handleConfigs()
    {
        $this->publishes([
            __DIR__.'/../config/helpers.php' => config_path('helpers.php'),
        ], 'helpers-config');
    }
}
