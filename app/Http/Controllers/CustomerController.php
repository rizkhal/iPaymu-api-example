<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Inertable\CustomerDatatable;
use App\Models\Customer;
use Illuminate\Http\RedirectResponse;
use Inertia\Response;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index(): Response
    {
        return inertia('customers/index')->datatable(new CustomerDatatable)->title(__('Manage Customer'));
    }

    public function store(CustomerRequest $request): RedirectResponse
    {
        try {
            DB::transaction(function () use ($request) {
                Customer::create($request->validated());
            });

            return back()->success(__('Successfully add new customer'));
        } catch (\Throwable $th) {
            dd($th);
            return back()->error($th->getMessage());
        }
    }

    public function update(CustomerRequest $request, Customer $customer): RedirectResponse
    {
        try {
            DB::transaction(function () use ($customer, $request) {
                $customer->update($request->validated());
            });

            return back()->success(__('Successfully update customer'));
        } catch (\Throwable $th) {
            return back()->error($th->getMessage());
        }
    }

    public function destroy(Customer $customer): RedirectResponse
    {
        try {
            DB::transaction(function () use ($customer) {
                $customer->delete();
            });

            return back()->success(__('Successfully delete customer'));
        } catch (\Throwable $th) {
            return back()->error($th->getMessage());
        }
    }
}
