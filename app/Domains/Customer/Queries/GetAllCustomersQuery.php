<?php

namespace App\Domains\Customer\Queries;

use App\Domains\Customer\Models\Customer;

class GetAllCustomersQuery
{
    public function handle(): array
    {
        return Customer::all()->toArray();
    }
}
