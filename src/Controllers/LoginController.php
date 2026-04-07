<?php

namespace App\Controllers;

use PXP\Exceptions\ValidationException;
use PXP\Http\Controllers\Controller;
use PXP\Http\Response\Redirect;
use PXP\Lib\Auth;

class LoginController extends Controller
{
    public function form()
    {
        return view('login');
    }

    public function login()
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

    public function logout()
    {
        Auth::logout();

        return Redirect::path('/');
    }
}
