<?php

namespace App\Foundation\Routing;

/**
 * Class Router
 *
 * Simple router for handling HTTP requests and invoking corresponding callbacks.
 */
class Router
{
    /** @var array List of middleware to be applied to routes. */
    protected array $middlewares = [];

    /** @var array List of registered routes. */
    protected array $routes = [];

    /**
     * Define a route for handling GET requests.
     *
     * @param string $uri
     * @param \Closure|array|string $callable
     */
    public function get(string $uri, \Closure|array|string $callable): void
    {
        $this->routes[] = new Route("GET", $uri, $callable);
    }

    /**
     * Define a route for handling POST requests.
     *
     * @param string $uri
     * @param \Closure|array|string $callable
     */
    public function post(string $uri, \Closure|array|string $callable): void
    {
        $this->routes[] = new Route("POST", $uri, $callable);
    }

    /**
     * Define a route for handling PATCH requests.
     *
     * @param string $uri
     * @param \Closure|array|string $callable
     */
    public function patch(string $uri, \Closure|array|string $callable): void
    {
        $this->routes[] = new Route("PATCH", $uri, $callable);
    }

    /**
     * Define a route for handling PUT requests.
     *
     * @param string $uri
     * @param \Closure|array|string $callable
     */
    public function put(string $uri, \Closure|array|string $callable): void
    {
        $this->routes[] = new Route("PUT", $uri, $callable);
    }

    /**
     * Define a route for handling DELETE requests.
     *
     * @param string $uri
     * @param \Closure|array|string $callable
     */
    public function delete(string $uri, \Closure|array|string $callable): void
    {
        $this->routes[] = new Route("DELETE", $uri, $callable);
    }

    public function getRoutes()
    {
        return $this->routes;
    }

    public function setRoutes(array $routes)
    {
        foreach ($routes as $route) {
            $route->setRouter($this)->setContainer($this->container);
        }

        $this->routes = $routes;

        $this->container->instance('routes', $this->routes);
    }

    /**
     * Handle the incoming request and invoke the corresponding route callback.
     *
     * @param string $uri
     * @param string $method
     *
     * @throws \Exception
     */
    public function handle(string $uri, string $method): void
    {
        foreach ($this->routes as $route) {
            if (
                ($params = RouteMatcher::matchRoute($route, $uri)) !== false
                && $route->getMethod() === strtoupper($method)
            ){
                $this->invokeCallable($route->getCallable(), $params);
                return;
            }
        }

        $this->invokeError();
    }

    /**
     * Invoke the callback associated with a matched route.
     *
     * @param \Closure|array|string $callable
     * @param array $params
     *
     * @throws \Exception
     */
    private function invokeCallable(\Closure|array|string $callable, array $params): void
    {
        if (is_callable($callable)) {
            call_user_func_array($callable, $params);
        } elseif (
            is_array($callable)
            || (is_string($callable) && strpos($callable, '@'))
        ) {
            [$controller, $action] = is_array($callable)
                ? $callable
                : explode('@', $callable);

            try {
                $reflectedMethod = new \ReflectionMethod($controller, $action);

                if ($reflectedMethod->isPublic() && !$reflectedMethod->isAbstract()) {
                    if ($reflectedMethod->isStatic()) {
                        forward_static_call_array([$controller, $action], $params);
                    } else {
                        call_user_func_array([is_string($controller) ? (new $controller) : $controller, $action], $params);
                    }
                }
            } catch (\ReflectionException $e) {
                throw new \RuntimeException("Received an exception while executing an action. Got: {$e}");
            }
        }
    }

    /**
     * Invoke an error response for unmatched routes.
     */
    private function invokeError(): void
    {
        header("HTTP/1.1 404 Not Found");
        exit;
    }
}
