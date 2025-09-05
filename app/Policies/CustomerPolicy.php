<?php

namespace App\Policies;

use App\Models\Customer;
use App\Models\User;

/**
 * Policy to ensure that users can only view, update, and delete their own customers.
 */
class CustomerPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function view(User $user, Customer $customer)
    {
        return $customer->user_id === $user->id;
    }

    public function update(User $user, Customer $customer)
    {
        return $customer->user_id === $user->id;
    }

    public function delete(User $user, Customer $customer): bool
    {
        return $customer->user_id === $user->id;
    }
}
