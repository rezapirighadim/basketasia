<?php

namespace App\Domains\Customer\Listeners;

use App\Domains\Customer\Events\CustomerCreatedEvent;
use Illuminate\Support\Facades\Log;

class CustomerCreatedListener
{
    public function handle(CustomerCreatedEvent $event)
    {
        $customer = $event->customer;
        // Perform any additional actions or logging related to customer creation
        Log::info('Customer created: ' . $customer->id);
    }
}


