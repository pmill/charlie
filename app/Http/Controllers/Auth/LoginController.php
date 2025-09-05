<?php

namespace App\Http\Controllers\Auth;

use App\Domain\Auth\Login\Login;
use App\Domain\Auth\Login\LoginRequest;
use App\Domain\Auth\Login\Logout;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Login $login, LoginRequest $request)
    {
        $loginResult = $login($request);

        if (! $loginResult) {
            return back()->withErrors([
                'email' => 'The provided credentials do not match our records.',
            ])->onlyInput('email');
        }

        return redirect()->intended(route('customers.index'));
    }

    public function logout(Logout $logout)
    {
        $logout();

        return redirect('/');
    }
}
