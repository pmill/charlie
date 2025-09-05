<?php

namespace App\Domain\Auth\Register;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;

/**
 * Handles the registration process by creating a new user and logging them in.
 */
class Register
{
    public function __invoke(RegisterRequest $request): User
    {
        $user = User::create($request->validated());

        event(new Registered($user));

        Auth::login($user);

        return $user;
    }
}
