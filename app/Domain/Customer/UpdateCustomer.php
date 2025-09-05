<?php

namespace App\Domain\Customer;

use App\Models\Customer;

/**
 * Handles the update of a customer using the validated data from the request.
 */
class UpdateCustomer
{
    public function __invoke(Customer $customer, UpdateCustomerRequest $request): bool
    {
        return $customer->update($request->validated());
    }
}
