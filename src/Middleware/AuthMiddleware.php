<?php

namespace App\Middleware;

use App\Auth;
use PXP\Core\Lib\Session;
use PXP\Core\Middleware\Middleware;

class AuthMiddleware extends Middleware
{
    public function apply(): mixed
    {
        return Auth::auth() ? true : view('login', [
            'errors' => Session::take('errors', []),
        ]);
    }
}
