<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Models\Customer;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/customers', [\App\Http\Controllers\Account\CustomerController::class, 'index'])
        ->name('customers.index')
        ->middleware('can:viewAny,' . Customer::class);
    Route::get('/customers/export', [\App\Http\Controllers\Account\CustomerController::class, 'export'])->name('customers.export')
        ->middleware('can:viewAny,' . Customer::class);
    Route::get('/customers/import', [\App\Http\Controllers\Account\CustomerController::class, 'showImportForm'])
        ->name('customers.import')
        ->middleware('can:create,' . Customer::class);
    Route::post('/customers/import', [\App\Http\Controllers\Account\CustomerController::class, 'import'])
        ->middleware('can:create,' . Customer::class);
    Route::get('/customers/add', [\App\Http\Controllers\Account\CustomerController::class, 'showAddForm'])
        ->name('customers.add')
        ->middleware('can:create,' . Customer::class);
    Route::post('/customers/add', [\App\Http\Controllers\Account\CustomerController::class, 'add'])
        ->middleware('can:create,' . Customer::class);

    Route::get('/customers/{customer}/{slug}', [\App\Http\Controllers\Account\CustomerController::class, 'detail'])
        ->name('customers.detail')
        ->middleware('can:view,customer');
    Route::get('/customers/{customer}/{slug}/delete', [\App\Http\Controllers\Account\CustomerController::class, 'showDeleteForm'])
        ->name('customers.delete')
        ->middleware('can:delete,customer');
    Route::post('/customers/{customer}/{slug}/delete', [\App\Http\Controllers\Account\CustomerController::class, 'delete'])
        ->middleware('can:delete,customer');
    Route::get('/customers/{customer}/{slug}/update', [\App\Http\Controllers\Account\CustomerController::class, 'showUpdateForm'])
        ->name('customers.update')
        ->middleware('can:update,customer');
    Route::post('/customers/{customer}/{slug}/update', [\App\Http\Controllers\Account\CustomerController::class, 'update'])
        ->middleware('can:update,customer');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/register/verify', [RegisterController::class, 'showEmailVerification'])->name('verification.notice');
Route::get('/register/verify/{id}/{hash}', [RegisterController::class, 'verify'])->middleware(['auth', 'signed'])->name('verification.verify');

Route::redirect('/', '/customers');
