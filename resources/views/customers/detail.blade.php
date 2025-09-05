@extends('layouts.app')

@section('title', 'Customer Detail')

@section('content')
    <div class="flex flex-col gap-8 relative overflow-x-auto">
        <div class="flex flex-col md:flex-row justify-between">
            <div class="items-end flex md:justify-end mb-4 md:mb-0">
                <x-breadcrumb :nodes="[
                    route('customers.index') => 'Customers',
                    url()->current() => $customer->name,
                ]" />
            </div>

            <div class="flex rounded-md">
                <a href="{{ route('customers.update', ['customer' => $customer->hash, 'slug' => $customer->name_slug]) }}" aria-current="page" class="px-4 py-2 text-sm font-medium text-blue-700 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 focus:z-10 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                    Update
                </a>
                <a href="{{ route('customers.delete', ['customer' => $customer->hash, 'slug' => $customer->name_slug]) }}" class="px-4 py-2 text-sm font-medium text-red-700 bg-white border-t border-b border-r border-gray-200 rounded-e-lg hover:bg-gray-100  focus:z-10 focus:text-red-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-red-500 dark:focus:text-white">
                    Delete
                </a>
            </div>
        </div>

        @if (session('success'))
            <div
                class=" bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded"
                role="alert"
            >
                <strong class="font-bold">Success!</strong>
                <span class="block">{{ session('success') }}</span>
            </div>
        @endif

        <div class="p-6 flex-1 shadow-md sm:rounded-lg bg-white dark:bg-neutral-900">
            <h2 class="group-hover:text-blue-600 font-semibold text-gray-800 dark:group-hover:text-neutral-400 dark:text-neutral-200 mb-2">
                Details
            </h2>

            <div class="space-y-3">
                <dl class="flex flex-col sm:flex-row gap-1">
                    <dt class="min-w-40">
                        <span class="block text-gray-500 dark:text-neutral-500">Name:</span>
                    </dt>
                    <dd>
                        <ul>
                            <li class="me-1 inline-flex items-center text-gray-800 dark:text-neutral-200">
                                {{ $customer->name }}
                            </li>
                        </ul>
                    </dd>
                </dl>

                <dl class="flex flex-col sm:flex-row gap-1">
                    <dt class="min-w-40">
                        <span class="block text-gray-500 dark:text-neutral-500">Email:</span>
                    </dt>
                    <dd>
                        <ul>
                            <li class="me-1 inline-flex items-center text-gray-800 dark:text-neutral-200">
                                {{ $customer->email }}
                            </li>
                        </ul>
                    </dd>
                </dl>

                <dl class="flex flex-col sm:flex-row gap-1">
                    <dt class="min-w-40">
                        <span class="block text-gray-500 dark:text-neutral-500">Phone:</span>
                    </dt>
                    <dd>
                        <ul>
                            <li class="me-1 inline-flex items-center text-gray-800 dark:text-neutral-200">
                                {{ $customer->phone }}
                            </li>
                        </ul>
                    </dd>
                </dl>

                <dl class="flex flex-col sm:flex-row gap-1">
                    <dt class="min-w-40">
                        <span class="block text-gray-500 dark:text-neutral-500">Organisation:</span>
                    </dt>
                    <dd>
                        <ul>
                            <li class="me-1 inline-flex items-center text-gray-800 dark:text-neutral-200">
                                {{ $customer->organisation }}
                            </li>
                        </ul>
                    </dd>
                </dl>

                <dl class="flex flex-col sm:flex-row gap-1">
                    <dt class="min-w-40">
                        <span class="block text-gray-500 dark:text-neutral-500">Job Title:</span>
                    </dt>
                    <dd>
                        <ul>
                            <li class="me-1 inline-flex items-center text-gray-800 dark:text-neutral-200">
                                {{ $customer->job_title }}
                            </li>
                        </ul>
                    </dd>
                </dl>
            </div>
        </div>

        <div class="p-6 shadow-md sm:rounded-lg bg-white dark:bg-neutral-900">
            <h2 class="group-hover:text-blue-600 font-semibold text-gray-800 dark:group-hover:text-neutral-400 dark:text-neutral-200 mb-2">
                Notes
            </h2>
            <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400 whitespace-pre-line">{{ $customer->notes ?? 'No notes have been entered for this customer.' }}</p>
        </div>

        <div class="p-6 shadow-md sm:rounded-lg bg-white dark:bg-neutral-900">
            <h2 class="group-hover:text-blue-600 font-semibold text-gray-800 dark:group-hover:text-neutral-400 dark:text-neutral-200 mb-2">
                Audit
            </h2>
            <ol class="relative border-s border-gray-200 dark:border-gray-700">
                @foreach($customer->auditLogs as $auditLog)
                    <li class="mb-10 ms-4">
                        <div class="absolute w-3 h-3 bg-gray-200 rounded-full mt-1.5 -start-1.5 border border-white dark:border-gray-900 dark:bg-gray-700"></div>
                        <time class="mb-1 text-sm font-normal leading-none text-gray-400 dark:text-gray-500">{{ $auditLog->created_at->diffForHumans() }}</time>
                        <p class="mb-4 text-base font-normal text-gray-500 dark:text-gray-400">
                            {{ $auditLog->description }}
                        </p>
                    </li>
                @endforeach
            </ol>
        </div>
    </div>
@endsection
