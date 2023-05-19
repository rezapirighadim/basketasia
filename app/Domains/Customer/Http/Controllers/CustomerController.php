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
use Illuminate\Http\Response;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *   title="Customer API",
 *   version="1.0.0",
 *   description="API endpoints for managing customers",
 *   @OA\Contact(
 *     email="admin@example.com"
 *   ),
 *   @OA\License(
 *     name="MIT"
 *   )
 * )
 * @OA\Schema(
 *   schema="Customer",
 *   required={"Firstname", "Lastname", "DateOfBirth", "PhoneNumber", "Email", "BankAccountNumber"},
 *   @OA\Property(property="Firstname", type="string", example="John"),
 *   @OA\Property(property="Lastname", type="string", example="Doe"),
 *   @OA\Property(property="DateOfBirth", type="string", format="date", example="1990-01-01"),
 *   @OA\Property(property="PhoneNumber", type="string", example="+123456789"),
 *   @OA\Property(property="Email", type="string", format="email", example="john@example.com"),
 *   @OA\Property(property="BankAccountNumber", type="string", example="1234567890"),
 * )
 * @OA\Schema(
 *   schema="CustomerRequest",
 *   required={"Firstname", "Lastname", "DateOfBirth", "PhoneNumber", "Email", "BankAccountNumber"},
 *   @OA\Property(property="Firstname", type="string", example="John"),
 *   @OA\Property(property="Lastname", type="string", example="Doe"),
 *   @OA\Property(property="DateOfBirth", type="string", format="date", example="1990-01-01"),
 *   @OA\Property(property="PhoneNumber", type="string", example="+123456789"),
 *   @OA\Property(property="Email", type="string", format="email", example="john@example.com"),
 *   @OA\Property(property="BankAccountNumber", type="string", example="1234567890"),
 * )
 */
class CustomerController extends Controller
{
    /**
     * @OA\Get(
     *   path="/customers",
     *   summary="Get all customers",
     *   @OA\Response(
     *     response=200,
     *     description="Successful operation",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(
     *         property="customers",
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/Customer")
     *       )
     *     )
     *   )
     * )
     */
    public function index()
    {
        $query = new GetAllCustomersQuery();
        $customers = $query->handle();
        return response()->json(['customers' => $customers], Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *   path="/customers",
     *   summary="Create a new customer",
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/CustomerRequest")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Successful operation",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(
     *         property="customer",
     *         ref="#/components/schemas/Customer"
     *       )
     *     )
     *   )
     * )
     */
    public function store(CustomerRequest $customerRequest)
    {
        $command = new CreateCustomerCommand($customerRequest->toArray());
        $customer = $command->handle();

        event(new CustomerCreatedEvent($customer));

        return response()->json(['customer' => $customer], Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *   path="/customers/{id}",
     *   summary="Get a customer by ID",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Customer ID",
     *     required=true,
     *     @OA\Schema(
     *       type="integer"
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Successful operation",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(
     *         property="customer",
     *         ref="#/components/schemas/Customer"
     *       )
     *     )
     *   )
     * )
     */
    public function show(Customer $customer)
    {
        $query = new GetCustomerByIdQuery($customer->id);
        $customer = $query->handle();

        return response()->json(['customer' => $customer], Response::HTTP_OK);
    }

    /**
     * @OA\Put(
     *   path="/customers/{id}",
     *   summary="Update a customer",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Customer ID",
     *     required=true,
     *     @OA\Schema(
     *       type="integer"
     *     )
     *   ),
     *   @OA\RequestBody(
     *     @OA\JsonContent(ref="#/components/schemas/CustomerRequest")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Successful operation",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         description="Success message"
     *       )
     *     )
     *   )
     * )
     */
    public function update(CustomerRequest $customerRequest, Customer $customer)
    {
        $command = new UpdateCustomerCommand($customer, $customerRequest->toArray());
        $customer = $command->handle();

        event(new CustomerUpdatedEvent($customer));
        return response()->json(['message' => __('customers.update_successfully')], Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *   path="/customers/{id}",
     *   summary="Delete a customer",
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     description="Customer ID",
     *     required=true,
     *     @OA\Schema(
     *       type="integer"
     *     )
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Successful operation",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(
     *         property="message",
     *         type="string",
     *         description="Success message"
     *       )
     *     )
     *   )
     * )
     */
    public function destroy(Customer $customer)
    {
        $command = new DeleteCustomerCommand($customer);
        $command->handle();

        event(new CustomerDeletedEvent($customer));
        return response()->json(['message' => __('customers.update_successfully')], Response::HTTP_OK);
    }
}
