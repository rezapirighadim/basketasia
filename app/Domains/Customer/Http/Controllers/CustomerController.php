<?php

namespace App\Domains\Customer\Http\Controllers;

use App\Domains\Customer\Http\Requests\CustomerRequest;
use App\Domains\Customer\Models\Customer;
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
        $customers = Customer::all();
        return response()->json(['customers' => $customers], Response::HTTP_OK);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $customerRequest)
    {
        return response()->json(['customer' => Customer::create($customerRequest->toArray())], Response::HTTP_OK);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return response()->json(['customer' => $customer ] , Response::HTTP_OK);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $customerRequest, Customer $customer)
    {
        $customer->update($customerRequest->toArray());
        return response()->json(['message' => __('customers.update_successfully') ], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return response()->json(['message' => __('customers.update_successfully') ], Response::HTTP_OK);
    }
}
