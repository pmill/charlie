<?php

namespace App\Domain\Auth\Login;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request class that encapsulates the validation rules for login.
 */
class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string',
        ];
    }

    /**
     * Customize the error messages.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'Email is mandatory.',
            'email.email' => 'Enter a valid email address.',
            'password.required' => 'Password is required.',
        ];
    }
}
