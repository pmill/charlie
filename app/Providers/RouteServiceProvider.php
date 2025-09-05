<?php

namespace App\Providers;

use App\Models\Customer;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // We are using hash ids for our public routes, so we need to bind the model to the route parameter using the hash.
        Route::bind(
            'customer',
            fn ($value) => Customer::with('user')->byHash($value)->firstOrFail(),
        );
    }
}
