<?php

namespace App;

class Auth
{
    public static function login(string $username, string $password): bool
    {
        $credentials = (array) config('credentials', []);

        $success = array_key_exists($username, $credentials)
            && $password === $credentials[$username];

        if($success) {
            session_regenerate_id();
            $_SESSION['username'] =  $username;
        }

        return $success;
    }

    public static function logout(): void
    {
        session_destroy();
    }

    public static function auth(): bool
    {
        return session('username') !== null;
    }
}
