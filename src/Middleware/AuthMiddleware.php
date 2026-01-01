<?php

namespace App\Middleware;

use PXP\Core\Middleware\Middleware;
use App\Auth;
use PXP\Core\Lib\Router;

class AuthMiddleware extends Middleware
{
    public function apply(): mixed
    {
        return Auth::auth() ? true : view('login');
    }
}
