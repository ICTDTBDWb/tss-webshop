<?php

namespace App\Foundation\Support\Facades;

use App\Foundation\Application;

//TODO: Make a little better.

/**
 * Abstract Facade class providing a convenient interface to interact with application services.
 */
abstract class Facade
{
    /**
     * The application instance.
     *
     * @var Application
     */
    protected static Application $app;

    /**
     * The resolved facade instances.
     *
     * @var array
     */
    protected static array $resolved_instances;

    /**
     * Indicates whether facade instances are cached.
     *
     * @var bool
     */
    protected static bool $cached = true;

    /**
     * Set the application instance on the facade.
     *
     * @param Application $app
     *
     * @return void
     */
    public static function setFacadeApplication(Application $app): void
    {
        static::$app = $app;
    }

    /**
     * Get the root object behind the facade.
     *
     * @return mixed
     */
    public static function getFacadeRoot(): mixed
    {
        return static::resolveFacadeInstance(static::getServiceBinding());
    }

    /**
     * Get the registered binding name for the facade.
     *
     * @return string
     * @throws \RuntimeException
     */
    protected static function getServiceBinding(): string
    {
        throw new \RuntimeException('Facade does not implement the getServiceBinding method.');
    }

    /**
     * Clear all the resolved instances.
     *
     * @return void
     */
    public static function clearResolvedInstances(): void
    {
        static::$resolved_instances = [];
    }

    /**
     * Resolve the facade root instance.
     *
     * @param string $name
     *
     * @return mixed
     */
    protected static function resolveFacadeInstance(string $name): mixed
    {
        if (isset(static::$resolved_instances[$name])) {
            return static::$resolved_instances[$name];
        }

        if (static::$app) {
            if (static::$cached) {
                return static::$resolved_instances[$name] = static::$app[$name];
            }

            return static::$app[$name];
        }
    }

    /**
     * Dynamically handle static method calls.
     *
     * @param string $method
     * @param array $args
     *
     * @return mixed
     * @throws \RuntimeException
     */
    public static function __callStatic(string $method, array $args)
    {
        $instance = static::getFacadeRoot();

        if (!$instance) {
            throw new \RuntimeException('A facade root has not been set.');
        }

        return $instance->$method(...$args);
    }
}
