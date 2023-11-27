<?php

namespace App\Foundation\Support\Facades;

/**
 * Facade for interacting with the application's router.
 *
 * @method static void get(string $route, \Closure|array|string $callable)
 * @method static void put(string $route, \Closure|array|string $callable)
 * @method static void patch(string $route, \Closure|array|string $callable)
 * @method static void update(string $route, \Closure|array|string $callable)
 * @method static void delete(string $route, \Closure|array|string $callable)
 * @method static void handle(string $route, \Closure|array|string $callable)
 */
class Router extends Facade
{
    /**
     * Get the registered binding by name.
     *
     * @return string
     */
    protected static function getServiceBinding(): string { return 'router'; }
}