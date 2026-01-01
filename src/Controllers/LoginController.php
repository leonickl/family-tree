<?php

namespace App\Controllers;

use PXP\Core\Controllers\Controller;
use App\Auth;
use PXP\Core\Lib\Router;
use PXP\Core\Exceptions\ValidationException;

class LoginController extends Controller
{
    public function form()
    {
        return view('login');
    }

    public function login()
    {
        $request = request(['username', 'password']);

        if(! is_string($request->username)) {
            throw new ValidationException('username must be a string');
        }

        if(! is_string($request->password)) {
            throw new ValidationException('password must be a string');
        }

        Auth::login($request->username, $request->password);

        Router::redirect('/');
    }

    public function logout()
    {
        Auth::logout();

        Router::redirect('/');
    }
}
