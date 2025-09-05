<?php

namespace App\Http\Controllers\Auth;

use App\Domain\Auth\Register\Register;
use App\Domain\Auth\Register\RegisterRequest;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Register $register, RegisterRequest $request)
    {
        $register($request);

        return redirect()->intended(route('customers.index'));
    }

    public function showEmailVerification()
    {
        return view('auth.verification-sent');
    }

    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return redirect('/login')->with('status', 'Email verified! You may now log in.');
    }
}
