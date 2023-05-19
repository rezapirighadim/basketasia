<?php

namespace App\Domains\Customer\Events;

use App\Domains\Customer\Models\Customer;
use Illuminate\Foundation\Events\Dispatchable;

class CustomerDeletedEvent
{
    use Dispatchable;

    public Customer $customer;

    public function __construct(Customer $customer)
    {
        $this->customer = $customer;
    }
}
