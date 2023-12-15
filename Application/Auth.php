<?php

class Auth
{
    private static ?self $instance = null;
    private Database|null $db = null;

    private function __construct() {
        $this->db ??= new Database();
    } // Private stub to prevent constructing of this instance.

    private function __clone() {} // Private stub to prevent cloning of this instance.

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
     * Check if the user is logged in.
     *
     * @return bool
     */
    public function isLoggedIn(): bool
    {
        return Session::get('auth')['logged_in'] ?? false;
    }

    /**
     * Retrieve the user is he is logged in.s
     *
     * @return array|false
     */
    public function user(): array|false
    {
        if (!$this->isLoggedIn()) return false;

        $table = Session::get('auth')['is_admin'] ? 'beheerders' : 'klanten';
        $result = $this->db->query(
            "SELECT * FROM $table WHERE id = ?",
            [Session::get('auth')['user_id']]
        )->first();

        unset($result['password']);

        return $result;
    }

    /**
     * Attempt to log in the user with credentials.
     *
     * @param array $credentials
     * @param bool $is_admin
     * @return bool
     */
    public function attempt(array $credentials, bool $is_admin = false): bool
    {
        $table = $is_admin ? 'beheerders' : 'klanten';
        $result = $this->db->query(
            "SELECT id, email, password FROM $table WHERE email = ?",
            [$credentials[0]]
        )->first();

        if (!$result) return false;

        if (!(password_verify($credentials[1], $result['password']))) return false;

        Session::set('auth', [
            'logged_in' => true,
            'user_id' => $result['id'],
            'is_admin' => $is_admin
        ]);

        session_regenerate_id(true);

        $this->db->close();

        return true;
    }

    /**
     * Redirect back to the homepage if unauthenticated.
     *
     * @param bool $is_admin
     * @return void
     */
    public function protectPage(bool $is_admin = false): void
    {
        if (!$this->isLoggedIn()) {
            $page = $is_admin ? 'beheer/login' : 'login';
            header("Location: $page");
            exit();
        }
    }

    /**
     * This function is called automatically when destructing.
     */
    public function __destruct() { $this->db->close(); }
}