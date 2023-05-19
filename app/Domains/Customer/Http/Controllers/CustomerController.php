<?php

namespace App\Domains\Customer\Http\Controllers;

use App\Domains\Customer\Commands\CreateCustomerCommand;
use App\Domains\Customer\Commands\DeleteCustomerCommand;
use App\Domains\Customer\Commands\UpdateCustomerCommand;
use App\Domains\Customer\Events\CustomerCreatedEvent;
use App\Domains\Customer\Events\CustomerDeletedEvent;
use App\Domains\Customer\Events\CustomerUpdatedEvent;
use App\Domains\Customer\Http\Requests\CustomerRequest;
use App\Domains\Customer\Models\Customer;
use App\Domains\Customer\Queries\GetAllCustomersQuery;
use App\Domains\Customer\Queries\GetCustomerByIdQuery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = new GetAllCustomersQuery();
        $customers = $query->handle();
        return response()->json(['customers' => $customers], Response::HTTP_OK);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $customerRequest)
    {
        $command = new CreateCustomerCommand($customerRequest->toArray());
        $customer = $command->handle();

        event(new CustomerCreatedEvent($customer));

        return response()->json(['customer' => $customer], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $query = new GetCustomerByIdQuery($customer->id);
        $customer = $query->handle();

        return response()->json(['customer' => $customer], Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $customerRequest, Customer $customer)
    {
        $command = new UpdateCustomerCommand($customer, $customerRequest->toArray());
        $customer = $command->handle();

        event(new CustomerUpdatedEvent($customer));
        return response()->json(['message' => __('customers.update_successfully')], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $command = new DeleteCustomerCommand($customer);
        $command->handle();

        event(new CustomerDeletedEvent($customer));
        return response()->json(['message' => __('customers.update_successfully')], Response::HTTP_OK);
    }
}
