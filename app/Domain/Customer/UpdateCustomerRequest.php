<?php

namespace App\Domain\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Request class that encapsulates the validation rules for updating a customer.
 */
class UpdateCustomerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:254',
                Rule::unique('customers')
                    ->ignore($this->customer->id)
                    ->where(function ($query) {
                        return $query->where('user_id', auth()->id());
                    }),
            ],
            'phone' => ['nullable', 'string', 'max:50'],
            'organisation' => ['nullable', 'string', 'max:255'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'date_of_birth' => ['nullable', 'date', 'date_format:Y-m-d', 'before:today'],
            'notes' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter the customer name.',
            'email.required' => 'Please enter an email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'date_of_birth.date' => 'Date of birth must be a valid date.',
            'date_of_birth.date_format' => 'Date of birth must be in YYYY-MM-DD format.',
            'date_of_birth.before' => 'Date of birth must be in the past.',
        ];
    }
}
