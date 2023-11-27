<?php

namespace App\Foundation\Support;

use App\Foundation\Application;

class ServiceProvider {

    /**
     * The application instance.
     *
     * @var Application
     */
    protected Application $app;

    /**
     * Create a new RouteServiceProvider instance.
     *
     * @param  Application  $app
     *
     * @return void
     */
    public function __construct(Application $app) { $this->app = $app; }

    /**
     * Defines the functions to be executed during the registration process.
     *
     * @return void
     */
    public function register() { }
}