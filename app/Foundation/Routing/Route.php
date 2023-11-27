<?php

namespace App\Foundation\Routing;

/**
 * Class Route
 *
 * Represents a route in the routing system with associated HTTP method, URI, and callback.
 */
class Route
{
    /** @var string The HTTP method for the route. */
    private string $method;

    /** @var string The URI pattern for the route. */
    private string $uri;

    /** @var array|string|\Closure The callback associated with the route. */
    private array|string|\Closure $callable;

    /**
     * Route constructor.
     *
     * @param string $method The HTTP method for the route.
     * @param string $uri The URI pattern for the route.
     * @param array|string|\Closure $callable The callback associated with the route.
     */
    public function __construct(
        string $method,
        string $uri,
        array|string|\Closure $callable
    ) {
        $this->method = $method;
        $this->uri = rtrim($uri, '/');
        $this->callable = $callable;
    }

    /**
     * Get the HTTP method associated with the route.
     *
     * @return string The HTTP method (e.g., GET, POST).
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Get the URI pattern associated with the route.
     *
     * @return string The URI pattern.
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * Get the callback associated with the route.
     *
     * @return array|string|\Closure The callback.
     */
    public function getCallable(): array|string|\Closure
    {
        return $this->callable;
    }
}
