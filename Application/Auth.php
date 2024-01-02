<?php

use JetBrains\PhpStorm\NoReturn;

class Auth
{
    const ADMIN_ROLE = 'admin';
    const WEBREDACTEUR_ROLE = 'webredacteur';
    const SEOSPECIALIST_ROLE = 'seospecialist';
    const KLANTENSERVICE_ROLE = 'klantenservice';
    const BEHEERDER_ROLES = [self::ADMIN_ROLE, self::WEBREDACTEUR_ROLE, self::SEOSPECIALIST_ROLE, self::KLANTENSERVICE_ROLE];

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
     * Retrieve the user is he is logged in.
     *
     * @return array|false
     */
    public function user(): array|false
    {
        if (!$this->isLoggedIn()) return false;

        $table = Session::get('auth')['is_admin'] ? 'medewerkers' : 'klanten';
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
        $table = $is_admin ? 'medewerkers' : 'klanten';
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
     * Log out the current user and clear its details from the session.
     *
     * @return void
     */
    #[NoReturn] public function logout(): void
    {
        Session::set('auth', [
            'logged_in' => false
        ]);

        session_regenerate_id();

        header("Location: /");
        exit;
    }

    /**
     * Log out the current user admin and clear its details from the session.
     *
     * @return void
     */
    #[NoReturn] public function logout_admin(): void
    {
        Session::set('auth', [
            'logged_in' => false,
            'is_admin' => false,
            'rol' => ""
        ]);

        session_regenerate_id();

        header("Location: /beheer/login");
        exit;
    }


    /**
     * Redirect to the login page if unauthenticated.
     *
     * @return void
     */
    public function protectPage(): void
    {
        $is_admin = Session::get('auth')['is_admin'] ?? false;
        if (!$this->isLoggedIn() && (!$is_admin || !isset($is_admin))) {
            header("Location: /login");
            exit();
        }
    }

    /**
     * Redirect to the admin login page if unauthenticated.
     *
     * @param array $accepted_roles
     * @return void
     */
    public function protectAdminPage(array $accepted_roles = []): void
    {
        $is_admin = Session::get('auth')['is_admin'] ?? false;

        if (
            !$this->isLoggedIn()
            || (!$is_admin && isset($is_admin))
        ) {
            header("Location: " . ($is_admin ? '/' : '/beheer/login'));
            exit();
        }

        if (
            !empty($accepted_roles)
            && !in_array($this->user()['rol'], $accepted_roles)
        ) {
            header("Location: /beheer");
            exit();
        }
    }

    /**
     * returns true if user has given role
     *
     * @param array $accepted_roles
     * @return bool
     */
    public function check_admin_rol(array $accepted_roles = []): bool
    {
        $ingelogd = false;
        if (
            !empty($accepted_roles) && !empty($this->user()['rol'])
            && in_array($this->user()['rol'], $accepted_roles)
        ) {
         $ingelogd = true;
        }

       return $ingelogd;
    }


    /**
     * This function is called automatically when destructing.
     */
    public function __destruct() { $this->db->close(); }
}