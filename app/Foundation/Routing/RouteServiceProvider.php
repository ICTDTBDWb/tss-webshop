<?php

namespace App\Foundation\Routing;

use App\Foundation\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Defines the functions to be executed during the registration process.
     *
     * @return void
     */
    public function register(): void
    {
        $this->registerRouter();
    }

    /**
     * Initializes the router as a singleton within the application, facilitating routing functionality.
     *
     * @return void
     */
    protected function registerRouter(): void
    {
        $this->app->singleton('router', function () {
            return new Router();
        });
    }

}