<?php

namespace App\Domain\Auth\Login;

use Illuminate\Support\Facades\Auth;

/**
 * Handles the login process by attempting authentication with the provided credentials
 * and regenerates the session upon successful login.
 *
 * @param  LoginRequest  $request  The request instance containing validated input and additional data.
 * @return bool Returns true if login is successful, otherwise false.
 */
class Login
{
    public function __invoke(LoginRequest $request): bool
    {
        $success = Auth::attempt($request->validated(), $request->filled('remember'));

        if ($success) {
            $request->session()->regenerate();
        }

        return $success;
    }
}
