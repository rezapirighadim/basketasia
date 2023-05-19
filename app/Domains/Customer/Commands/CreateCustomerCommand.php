<?php

namespace App\Domains\Customer\Commands;

use App\Domains\Customer\Models\Customer;

class CreateCustomerCommand
{
    private array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function handle(): Customer
    {
        return Customer::create($this->data);
    }
}
