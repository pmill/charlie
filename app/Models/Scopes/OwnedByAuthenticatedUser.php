<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

/**
 * Scope to filter records by the authenticated user's ID. This scope is typically used for the Customer model so only
 * customers owned by the authenticated user are returned.
 */
class OwnedByAuthenticatedUser implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $userId = Auth::id();
        if (empty($userId)) {
            throw new \Exception('User not authenticated');
        }

        $builder->where('user_id', $userId);
    }
}
