<?php

namespace App;

class Auth
{
    public static function login(string $username, string $password): bool
    {
        $users = config('users', []);

        foreach($users as $user) {
            if($user->username === $username && password_verify($password, $user->password_hash)) {
                session_regenerate_id();
                $_SESSION['username'] =  $username;
                return true;
            }
        }

        return false;
    }

    public static function logout(): void
    {
        session_destroy();
    }

    public static function auth(): bool
    {
        return session('username') !== null;
    }

    public static function user(): ?object
    {
        if(! self::auth()) {
            return null;
        }

        $users = (array) config('users', []);
        $username = session('username');

        foreach($users as $user) {
            if($user->username === $username) {
                return $user;
            }
        }

        return null;
    }
}
