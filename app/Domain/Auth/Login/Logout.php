<?php

namespace App\Domain\Auth\Login;

use Illuminate\Support\Facades\Auth;

/**
 * Handles the logout process by invalidating the user's session and regenerating the CSRF token.
 */
class Logout
{
    public function __invoke(): void
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
}
