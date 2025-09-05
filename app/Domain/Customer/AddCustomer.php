<?php

namespace App\Domain\Customer;

use App\Models\Customer;

/**
 * Handles the addition of a new customer using the validated data from the request.
 */
class AddCustomer
{
    public function __invoke(AddCustomerRequest $request): Customer
    {
        return Customer::create($request->validated());
    }
}
