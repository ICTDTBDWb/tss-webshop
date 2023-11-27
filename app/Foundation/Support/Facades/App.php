<?php

namespace App\Foundation\Support\Facades;

//TODO: Implement the remaining function into facade.

/**
 * Facade for interacting with the application instance.
 *
 * @method static bool isBooted()
 * @method static bool boot()
 * @method static mixed register(mixed $provider, bool $force = false)
 */
class App extends Facade
{
    /**
     * Get the registered binding by name
     *
     * @return string
     */
    protected static function getServiceBinding(): string { return 'app'; }
}