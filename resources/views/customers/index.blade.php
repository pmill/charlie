@extends('layouts.app')

@section('title', 'Customers')

@section('content')
    @if (session('success'))
        <div
            class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6"
            role="alert"
        >
            <strong class="font-bold">Success!</strong>
            <span class="block">{{ session('success') }}</span>
        </div>
    @endif

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg bg-white dark:bg-gray-900">
        <div class="rounded-md flex flex-col md:flex-row justify-between items-center px-4 my-4">
            <form method="get" action="{{ url()->full() }}">
                <x-hidden-query-inputs :exclude="['filter.search', 'filter.organisation']" />

                <div class="flex items-center flex-col md:flex-row">
                    <div class="relative">
                        <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input
                            type="text"
                            id="table-search"
                            name="filter[search]"
                            class="block h-10 py-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Search for items"
                            value="{{ request()->query('filter')['search'] ?? '' }}"
                        >
                    </div>

                    <select
                        id="organisations"
                        name="filter[organisation]"
                        class="mt-4 md:mt-0 md:ml-4 py-0 h-10 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full px-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        onchange="this.form.submit()"
                    >
                        <option>Filter by organisation...</option>
                        @foreach ($organisations as $organisation)
                            <option value="{{ $organisation }}" {{ request('filter.organisation') == $organisation ? 'selected' : '' }}>{{ $organisation }}</option>
                        @endforeach
                    </select>
                </div>
            </form>

            <div class="mt-6 md:mt-0">
                <a href="{{ route('customers.import') }}" aria-current="page" class="px-4 py-2 text-sm font-medium text-blue-700 bg-white border border-gray-200 rounded-s-lg hover:bg-gray-100 focus:z-10 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                    Import
                </a>
                <a href="{{ route('customers.export', request()->query()) }}" class="px-4 py-2 text-sm font-medium text-blue-700 bg-white border-t border-b border-r border-gray-200 hover:bg-gray-100  focus:z-10 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                    Export
                </a>
                <a href="{{ route('customers.add') }}" class="px-4 py-2 text-sm font-medium text-blue-700 bg-white border-t border-b border-r border-gray-200 rounded-e-lg hover:bg-gray-100  focus:z-10 focus:text-blue-700 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-blue-500 dark:focus:text-white">
                    Add
                </a>
            </div>
        </div>

        <div class="overflow-x-auto vw-full">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 overflow-x-auto">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        <a href="{{ $page->sortUrl('name') }}">Customer Name</a>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <a href="{{ $page->sortUrl('email') }}">Email</a>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <a href="{{ $page->sortUrl('phone') }}">Phone</a>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <a href="{{ $page->sortUrl('job_title') }}">Job Title</a>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <a href="{{ $page->sortUrl('organisation') }}">Organisation</a>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <a href="{{ $page->sortUrl('created_at') }}">Created</a>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <a href="{{ $page->sortUrl('updated_at') }}">Updated</a>
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach($page as $customer)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                        {{$customer->name}}
                    </th>
                    <td class="px-6 py-4">
                        {{$customer->email}}
                    </td>
                    <td class="px-6 py-4">
                        {{$customer->formatted_phone}}
                    </td>
                    <td class="px-6 py-4">
                        {{$customer->job_title}}
                    </td>
                    <td class="px-6 py-4">
                        {{$customer->organisation}}
                    </td>
                    <td class="px-6 py-4">
                        {{$customer->created_at->diffForHumans()}}
                    </td>
                    <td class="px-6 py-4">
                        {{$customer->updated_at->diffForHumans()}}
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ route('customers.detail', ['customer' => $customer->hash, 'slug' => $customer->name_slug]) }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">View</a>
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between p-4" aria-label="Table navigation">
            <span class="text-sm font-normal text-gray-500 dark:text-gray-400 md:mb-0 block w-full md:inline md:w-auto">
                Showing <span class="font-semibold text-gray-900 dark:text-white">
                    {{ $page->firstItem() }}-{{ $page->lastItem() }}
                </span> of
                <span class="font-semibold text-gray-900 dark:text-white">{{ $page->total() }}</span>
            </span>
            <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8 mt-4 md:mt-0">
                <li>
                    <a href="{{ $page->previousPageUrl() }}" class="flex items-center justify-center px-3 h-8 ms-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-s-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Previous</a>
                </li>
                <li>
                    <a href="{{ $page->nextPageUrl() }}" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-e-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white">Next</a>
                </li>
            </ul>
        </nav>
    </div>
@endsection
