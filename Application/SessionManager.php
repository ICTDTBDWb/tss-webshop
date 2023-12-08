<?php

namespace application;

class SessionManager
{
    private static ?self $instance = null;

    private function __construct()
    {
        if (self::$instance === null) {
            // Start the session if it does not exist yet.
            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }
        }
    }
    private function __clone()
    {
        // Private clone method to prevent cloning of the instance.
    }

    /**
     * Get the current instance if it exists or create a new instance.
     *
     * @return self
     */
    public static function getInstance(): self
    {

        return self::$instance ??= new self();
    }

    /**
     * Try to get a value from the session.
     *
     * @param string $variable
     *
     * @return string|null
     */
    public function get(string $variable): mixed
    {
        return $_SESSION[$variable] ?? null;
    }

    /**
     * Store a new value inside the current session.
     *
     * @param string $variable
     * @param string $value
     *
     * @return void
     */
    public function set(string $variable, string $value): void
    {
        $_SESSION[$variable] = $value;
    }

    /**
     * Check if the given value exists in the session.
     *
     * @param string $variable
     *
     * @return bool
     */
    public function exists(string $variable): bool
    {
        return array_key_exists($variable, $_SESSION);
    }

    /**
     * Flush and close the current session.
     *
     * @return void
     */
    public function flush(): void
    {
        session_unset();
        session_destroy();
    }
}
