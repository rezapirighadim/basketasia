<?php

namespace App\Domains\Customer\Commands;

use App\Domains\Customer\Models\Customer;

class DeleteCustomerCommand
{
    private Customer $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }

    public function handle(): void
    {
        $this->customer->delete();
    }
}
