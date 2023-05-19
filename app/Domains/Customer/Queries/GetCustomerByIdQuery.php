<?php

namespace App\Domains\Customer\Queries;

use App\Domains\Customer\Models\Customer;

class GetCustomerByIdQuery
{
    private int $customerId;

    public function __construct(int $customerId)
    {
        $this->customerId = $customerId;
    }

    public function handle(): ?Customer
    {
        return Customer::find($this->customerId);
    }
}
