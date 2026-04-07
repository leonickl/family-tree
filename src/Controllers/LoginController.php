<?php

namespace App\Controllers;

use PXP\Exceptions\ValidationException;
use PXP\Http\Controllers\Controller;
use PXP\Http\Response\Redirect;
use PXP\Http\Response\Response;
use PXP\Lib\Auth;

class LoginController extends Controller
{
    public function form(): Response
    {
        return view('login');
    }

    public function login(): Response
    {
        $request = request(['username', 'password']);

        if (! is_string($request->username)) {
            throw new ValidationException('username must be a string');
        }

        if (! is_string($request->password)) {
            throw new ValidationException('password must be a string');
        }

        Auth::login($request->username, $request->password);

        return Redirect::path('/');
    }

    public function logout(): Response
    {
        Auth::logout();

        return Redirect::path('/');
    }
}
