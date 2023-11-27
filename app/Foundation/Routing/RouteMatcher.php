<?php

namespace App\Foundation\Routing;

/**
 * Class RouteMatcher
 *
 * Utility class for matching routes and extracting parameters from URIs.
 */
class RouteMatcher
{
    /**
     * Match the given route and URI, extracting parameters if a match is found.
     *
     * @param Route $route The route to match.
     * @param string $uri The URI to match against the route.
     *
     * @return array|false An array of matched parameters or false if no match is found.
     */
    public static function matchRoute(Route $route, string $uri): array|false
    {
        $matches = [];

        if (
            self::patternMatches(
                $route->getUri(),
                rtrim($uri, '-'),
                $matches,
                PREG_OFFSET_CAPTURE
            )
        ) {
            return self::extractParameters(array_slice($matches, 1));
        }

        return false;
    }

    /**
     * Extract parameters from the matches array.
     *
     * @param array $matches The array of matches.
     *
     * @return array The extracted parameters.
     */
    private static function extractParameters(array $matches): array
    {
        return array_map(static function ($match, $index) use ($matches) {
            if (isset($matches[$index + 1][0][1]) && $matches[$index + 1][0][1] > -1) {
                return trim(substr($match[0][0], 0, $matches[$index + 1][0][1] - $match[0][1]), '-');
            }

            return isset($match[0][0], $match[0][1]) && $match[0][1] !== -1 ? trim($match[0][0], '-') : null;
        }, $matches, array_keys($matches));
    }

    /**
     * Perform a pattern match between the URI and the specified pattern.
     *
     * @param string $pattern The pattern to match against.
     * @param string $uri The URI to match.
     * @param array $matches An array to store matches.
     * @param int $flags Additional flags for the pattern match.
     *
     * @return bool True if there is a match, false otherwise.
     */
    private static function patternMatches(string $pattern, string $uri, array &$matches, int $flags): bool
    {
        // Convert route parameters in the pattern to regular expression groups.
        $pattern = preg_replace('/\/{(.*?)}/', '/(.*?)', $pattern);

        // Perform a pattern match against the URI.
        return (bool)preg_match_all('#^' . $pattern . '$#', $uri, $matches, $flags);
    }
}
