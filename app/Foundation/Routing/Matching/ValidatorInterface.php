<?php

namespace App\Foundation\Routing\Matching;

use App\Foundation\Routing\Route;

interface ValidatorInterface
{
    /**
     * Validate a given rule against a route and request.
     *
     * @param Route $route
     * @param array $request
     * @return bool
     */
    public function matches(Route $route, array $request): bool;
}