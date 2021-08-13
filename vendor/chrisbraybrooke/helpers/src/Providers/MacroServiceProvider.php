<?php

namespace ChrisBraybrooke\Helpers\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as BaseProvider;
use Illuminate\Support\Facades\Response;

class MacroServiceProvider extends BaseProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerResponseMacros();  
    }

    /**
     * Register the macros for responses.
     *
     * @return void
     */
    public function registerResponseMacros()
    {
       Response::macro('deletedOk', function () {
            return $this->json(['deleted' => 'Ok'], 202);
        });

        Response::macro('completedOk', function () {
            return $this->json(['completed' => true], 200);
        });
    }
}