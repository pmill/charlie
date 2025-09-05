<?php

namespace App\Domain\Auth\Register;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Request class that encapsulates the validation rules for registration.
 */
class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:254', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Name is mandatory.',
            'name.string' => 'Name must be a string.',
            'name.max' => 'Name cannot be more than 255 characters.',
            'email.required' => 'Email is mandatory.',
            'email.string' => 'Email must be a string.',
            'email.email' => 'Enter a valid email address.',
            'email.max' => 'Email cannot be more than 254 characters.',
            'email.unique' => 'An account with this email already exists.',
            'password.required' => 'Password is required.',
            'password.string' => 'Password must be a string.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.confirmed' => 'Passwords must match.',
        ];
    }
}
