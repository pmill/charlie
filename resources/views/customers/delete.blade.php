@extends('layouts.app')

@section('title', 'Delete Customer')

@section('content')
    <div class="flex flex-col gap-8 relative overflow-x-auto">
        <div class="flex justify-between">
            <div class="items-end flex justify-end">
                <x-breadcrumb :nodes="[
                    route('customers.index') => 'Customers',
                    route('customers.detail', ['customer' => $customer->hash, 'slug' => $customer->name_slug]) => $customer->name,
                    url()->current() => 'Delete',
                ]" />
            </div>
        </div>

        <div class="p-6 flex-1 shadow-md sm:rounded-lg bg-white dark:bg-neutral-900 max-w-md">
            <h2 class="group-hover:text-blue-600 font-semibold text-gray-800 dark:group-hover:text-neutral-400 dark:text-neutral-200 mb-2">
                Delete Customer
            </h2>

            <form method="post">
                @csrf

                <p class="text-gray-600 dark:text-neutral-400">
                    Are you sure you want to delete this customer?
                </p>

                <div class="mt-6 flex justify-end gap-4">
                    <a href="{{ url()->previous() }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">No, Cancel</a>
                    <button type="submit" class="cursor-pointer text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">Yes, Delete</button>
                </div>
            </form>
        </div>
    </div>
@endsection
