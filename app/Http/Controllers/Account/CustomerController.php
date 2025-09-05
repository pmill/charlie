<?php

namespace App\Http\Controllers\Account;

use App\Domain\Customer\AddCustomer;
use App\Domain\Customer\AddCustomerRequest;
use App\Domain\Customer\UpdateCustomer;
use App\Domain\Customer\UpdateCustomerRequest;
use App\Exports\CustomersExport;
use App\Http\Controllers\Controller;
use App\Imports\CustomersImport;
use App\Models\Customer;
use App\Models\Pagination\Paginator;
use App\Models\Sortable\Direction;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $page = Customer::filter($request->query('filter') ?? [])
            ->sortable(
                $request->query('sort', 'updated_at'),
                Direction::tryFrom($request->query('direction', 'desc'))
            )
            ->paginate($request->query('limit', 10))
            ->withQueryString();

        $organisations = Customer::select('organisation')
            ->distinct()
            ->orderBy('organisation')
            ->pluck('organisation');

        return view(
            'customers.index',
            [
                'page' => Paginator::fromLaravelPaginator($page),
                'organisations' => $organisations,
            ],
        );
    }

    public function export(Request $request)
    {
        $export = (new CustomersExport)
            ->setFilter($request->query('filter') ?? [])
            ->setSort($request->query('sort', 'updated_at'))
            ->setDirection(Direction::tryFrom($request->query('direction', 'desc')))
            ->setTemplate($request->filled('template') ?? false);

        return Excel::download($export, 'customers.xlsx');
    }

    public function import(Request $request)
    {
        $request->validate([
            'import' => 'required|file|mimes:xlsx,xls,csv',
        ]);

        Excel::import(new CustomersImport, $request->file('import'));

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customers imported successfully!');
    }

    public function detail(Customer $customer, string $slug)
    {
        return view(
            'customers.detail',
            [
                'customer' => $customer,
            ]
        );
    }

    public function add(AddCustomerRequest $request, AddCustomer $addCustomer)
    {
        $customer = $addCustomer($request);

        return redirect()
            ->route('customers.detail', ['customer' => $customer->hash, 'slug' => $customer->name_slug])
            ->with('success', 'Customer created successfully!');
    }

    public function update(Customer $customer, UpdateCustomerRequest $request, UpdateCustomer $updateCustomer)
    {
        $updateCustomer($customer, $request);

        return redirect()
            ->route('customers.detail', ['customer' => $customer->hash, 'slug' => $customer->name_slug])
            ->with('success', 'Customer updated successfully!');
    }

    public function delete(Customer $customer)
    {
        $customer->delete();

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer deleted successfully!');
    }

    public function showDeleteForm(Customer $customer, string $slug)
    {
        return view(
            'customers.delete',
            [
                'customer' => $customer,
            ]
        );
    }

    public function showUpdateForm(Customer $customer, string $slug)
    {
        return view(
            'customers.update',
            [
                'customer' => $customer,
            ]
        );
    }

    public function showAddForm()
    {
        return view('customers.add');
    }

    public function showImportForm()
    {
        return view('customers.import');
    }
}
