<?php

namespace ChrisBraybrooke\NAMESPACE_HERE;

use ChrisBraybrooke\NAMESPACE_HERE\Providers\EventServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\FileSystem\FileSystem;

class ServiceProvider extends ServiceProvider
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
        if (!config('CONFIG_NAME.ignore_migrations')) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');            
        }

        $this->publishes([
            __DIR__.'/../database/migrations/' => database_path('migrations')
        ], 'PACKAGE_NAME-migrations');
    }

    /** 
     * Register any translations.
     *
     * @return void
     */
    private function handleTranslations()
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'PACKAGE_NAME');

        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/PACKAGE_NAME'),
        ], 'PACKAGE_NAME-translations');
    }

    /** 
     * Merge the config files from both the package and application.
     *
     * @return void
     */
    private function mergeConfig()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/CONFIG_NAME.php', 'CONFIG_NAME'
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
            __DIR__.'/../config/CONFIG_NAME.php' => config_path('CONFIG_NAME.php')
        ], 'PACKAGE_NAME-config');
    }

    /** 
     * Register any routes this package needs.
     *
     * @return void
     */
    private function handleRoutes()
    {
        Route::group([
            'name' => 'PACKAGE_NAME-web',
            'prefix' => 'PACKAGE_NAME.web',
            'namespace' => 'ChrisBraybrooke\NAMESPACE_HERE\Http\Controllers',
            'middleware' => ['web']
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });

        Route::group([
            'name' => 'PACKAGE_NAME-web',
            'prefix' => 'PACKAGE_NAME.api',
            'namespace' => 'ChrisBraybrooke\NAMESPACE_HERE\Http\Controllers\Api',
            'middleware' => ['api']
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/api.php');
        });
    }
}
