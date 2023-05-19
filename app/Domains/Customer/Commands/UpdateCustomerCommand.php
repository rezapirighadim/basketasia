<?php

namespace App\Domains\Customer\Commands;

use App\Domains\Customer\Models\Customer;

class UpdateCustomerCommand
{
    private Customer $customer;
    private array $data;

    public function __construct(Customer $customer, array $data)
    {
        $this->customer = $customer;
        $this->data = $data;
    }

    public function handle(): Customer
    {
        $this->customer->update($this->data);
        return $this->customer;
    }
}
