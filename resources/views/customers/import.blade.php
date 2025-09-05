@extends('layouts.app')

@section('title', 'Import Customers')

@section('content')
    <div class="flex flex-col gap-8 relative overflow-x-auto">
        <div class="flex justify-between">
            <div class="items-end flex justify-end">
                <x-breadcrumb :nodes="[
                    route('customers.index') => 'Customers',
                    url()->current() => 'Import',
                ]" />
            </div>
        </div>

        <div class="p-6 flex-1 shadow-md sm:rounded-lg bg-white dark:bg-neutral-900">
            <h2 class="group-hover:text-blue-600 font-semibold text-gray-800 dark:group-hover:text-neutral-400 dark:text-neutral-200 mb-2">
                Import Customers
            </h2>

            <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                Use the form below to import customers from an excel or CSV file. Download a
                <a href="{{ route('customers.export', ['template' => true]) }}" class="inline-flex font-medium items-center text-blue-600 hover:underline">template file</a> or
                <a href="{{ route('customers.export') }}" class="inline-flex font-medium items-center text-blue-600 hover:underline">export existing customers</a>.
            </p>
        </div>

        <div class="p-6 flex-1 shadow-md sm:rounded-lg bg-white dark:bg-neutral-900">
            <form class="max-w-lg" method="post" enctype="multipart/form-data">
                @csrf

                @if (session('status'))
                    <div class="mb-4 text-green-600">
                        {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 text-red-600">
                        <ul class="list-disc pl-4">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-4">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="import">
                        Upload file
                    </label>
                    <input class="block p-2 w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" type="file" accept=".csv, .xls, .xlsx" name="import" id="import">
                </div>

                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Submit
                </button>
            </form>
        </div>
    </div>
@endsection
