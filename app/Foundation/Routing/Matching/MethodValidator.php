<?php

namespace App\Foundation\Routing\Matching;

use App\Foundation\Routing\Route;

class MethodValidator implements ValidatorInterface
{

    /**
     * Validate a given rule against a route and request.
     *
     * @param Route $route
     * @param array $request
     * @return bool
     */
    public function matches(Route $route, array $request): bool
    {
        return in_array($request->getMethod(), $route->methods(), true);
    }
}