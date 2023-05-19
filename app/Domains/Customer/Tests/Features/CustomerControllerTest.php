<?php

namespace App\Domains\Customer\Tests\Features;

use App\Domains\Customer\Http\Controllers\CustomerController;
use App\Domains\Customer\Http\Requests\CustomerRequest;
use App\Domains\Customer\Models\Customer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class CustomerControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Migrate the database
        Artisan::call('migrate');
    }

    /**
     * Test the index method of the CustomerController.
     *
     * @test
     */
    public function it_can_get_a_list_of_customers()
    {
        // Create some customers
        Customer::factory()->count(5)->create();

        // Send a GET request to the index method
        $response = $this->get(route('customers.index'));

        // Assert the response status code is 200 (HTTP_OK)
        $response->assertStatus(Response::HTTP_OK);

        // Assert the response JSON structure
        $response->assertJsonStructure(['customers']);

        // Assert the number of customers returned in the response
        $response->assertJsonCount(5, 'customers');
    }

    /**
     * Test the store method of the CustomerController.
     *
     * @test
     */
    public function it_can_create_a_customer()
    {
        // Create a sample customer data
        $customerData = Customer::factory()->make()->toArray();

        // Send a POST request to the store method with the customer data
        $response = $this->post(route('customers.store'), $customerData);

        // Assert the response status code is 200 (HTTP_OK)
        $response->assertStatus(Response::HTTP_OK);

        // Assert the response JSON structure
        $response->assertJsonStructure(['customer']);

        // Assert the customer data in the response matches the created customer
        $response->assertJson(['customer' => $customerData]);

        // Assert the customer is stored in the database
        $this->assertDatabaseHas('customers', $customerData);
    }

    /**
     * Test the show method of the CustomerController.
     *
     * @test
     */
    public function it_can_show_a_customer()
    {
        // Create a customer
        $customer = Customer::factory()->create();

        // Send a GET request to the show method with the customer's ID
        $response = $this->get(route('customers.show', ['customer' => $customer->id]));

        // Assert the response status code is 200 (HTTP_OK)
        $response->assertStatus(Response::HTTP_OK);

        // Assert the response JSON structure
        $response->assertJsonStructure(['customer']);

        // Assert the customer data in the response matches the created customer
        $response->assertJson(['customer' => $customer->toArray()]);
    }

    /**
     * Test the update method of the CustomerController.
     *
     * @test
     */
    public function it_can_update_a_customer()
    {
        // Create a customer
        $customer = Customer::factory()->create();

        // Create updated customer data
        $updatedCustomerData = Customer::factory()->make()->toArray();

        // Send a PUT request to the update method with the updated customer data
        $response = $this->put(route('customers.update', ['customer' => $customer->id]), $updatedCustomerData);

        // Assert the response status code is 200 (HTTP_OK)
        $response->assertStatus(Response::HTTP_OK);

        // Assert the response JSON structure
        $response->assertJsonStructure(['message']);

        // Assert the success message in the response
        $response->assertJson(['message' => __('customers.update_successfully')]);

        // Refresh the customer data from the database
        $customer->refresh();

        // Assert the customer data in the database is updated
        $this->assertEquals($updatedCustomerData['firstname'], $customer->firstname);
        // Add more assertions for other fields if necessary
    }

    /**
     * Test the destroy method of the CustomerController.
     *
     * @test
     */
    public function it_can_delete_a_customer()
    {
        // Create a customer
        $customer = Customer::factory()->create();

        // Send a DELETE request to the destroy method with the customer's ID
        $response = $this->delete(route('customers.destroy', ['customer' => $customer->id]));

        // Assert the response status code is 200 (HTTP_OK)
        $response->assertStatus(Response::HTTP_OK);

        // Assert the response JSON structure
        $response->assertJsonStructure(['message']);

        // Assert the success message in the response
        $response->assertJson(['message' => __('customers.update_successfully')]);

        // Assert the customer is deleted from the database
        $this->assertDatabaseMissing('customers', ['id' => $customer->id]);
    }
}
