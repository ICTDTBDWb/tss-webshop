<?php

class Session
{
    /**
     * Get a value from the session.
     *
     * @param string $key
     * @return mixed
     */
    public static function get(string $key): mixed
    {
        return $_SESSION[$key] ?? null;
    }

    /**
     * Store a new value in the session.
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Check if a value exists in the session.
     *
     * @param string $key
     * @return bool
     */
    public static function exists(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Flush the current session data.
     *
     * @return void
     */
    public static function flush(): void
    {
        $_SESSION = [];
    }

    /**
     * Destroy the current session.
     *
     * @return void
     */
    public static function destroy(): void
    {
        static::flush();
        session_destroy();
    }
}