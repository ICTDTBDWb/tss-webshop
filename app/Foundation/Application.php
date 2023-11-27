<?php

namespace App\Foundation;

use App\Foundation\Container\Container;
use App\Foundation\Routing\RouteServiceProvider;

class Application extends Container
{
    /**
     * Indicates whether the application has been booted.
     *
     * @var bool
     */
    protected bool $booted = false;

    /**
     * The array of registered service providers.
     *
     * @var array
     */
    protected array $service_providers = [];

    /**
     * The array of loaded service providers.
     *
     * @var array
     */
    protected array $loaded_providers = [];

    public function __construct()
    {
        // Register the application bindings.
        static::setInstance($this);

        $this->bind('app', $this);
        $this->bind(Container::class, $this);

        // Register the base providers.
        $this->register(new RouteServiceProvider($this));
    }

    /**
     * +--------------------------------------------------------------------+
     * | Booting the Application.
     * +--------------------------------------------------------------------+
     */

    /**
     * Determine if the application has been booted.
     *
     * @return bool
     */
    public function isBooted(): bool
    {
        return $this->booted;
    }

    /**
     * Boots the application and its base providers.
     *
     * @return void
     */
    public function boot(): void
    {
        // If the application is already booted, return as it's not needed to boot again.
        if ($this->isBooted()) { return; }

        // Boot the base providers.
        $this->bootProvider();

        // Indicate that the application is booted.
        $this->booted = true;
    }

    /**
     * +--------------------------------------------------------------------+
     * | Registering the providers.
     * +--------------------------------------------------------------------+
     */

    /**
     * Register a new service provider
     *
     * @param mixed $provider
     * @param bool $force
     *
     * @return mixed
     */
    public function register(mixed $provider, bool $force = false): mixed
    {
        // Check if the provider is already registered and force flag is not set.
        // If registered and not forced, return the registered instance.
        if (
            ($registered = array_values(
                array_filter(
                    $this->service_providers,
                    static fn ($value) => $value instanceof (
                        is_string($provider)
                            ? $provider
                            : get_class($provider)
                        ),
                    ARRAY_FILTER_USE_BOTH
                )
            )[0] ?? null)
            && !$force
        ) {
            return $registered;
        }

        if (is_string($provider)) {
            $provider = new $provider($this);
        }

        $provider->register();

        // Bind the providers to the application.
        foreach (['bindings', 'singletons'] as $property) {
            if (property_exists($provider, $property)) {
                array_map(
                    fn ($key, $value) =>
                    ($property === 'bindings')
                        ? $this->bind($key, $value)
                        : $this->singleton($key, $value)
                    ,
                    ...array_map(
                        static fn ($item) =>
                        is_int($item)
                            ? [$item]
                            : $item, $provider->$property
                    )
                );
            }
        }

        // Add the providers to the array since they are booted.
        $this->service_providers[] = $provider;
        $this->loaded_providers[get_class($provider)] = true;

        // If the application is booted we want to boot the registered providers.
        $this->isBooted() && $this->bootProvider();

        return $provider;
    }

    /**
     * Boot the registered service providers.
     *
     * @return void
     */
    private function bootProvider(): void
    {

        // Call the boot method on providers if it exists.
        array_walk(
            $this->service_providers,
            static fn ($p) => method_exists($p, 'boot') && $this->call([$p, 'boot'])
        );
    }
}
