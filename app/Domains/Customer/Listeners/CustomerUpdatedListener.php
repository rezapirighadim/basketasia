<?php

namespace App\Domains\Customer\Listeners;

use App\Domains\Customer\Events\CustomerUpdatedEvent;
use Illuminate\Support\Facades\Log;

class CustomerUpdatedListener
{
    public function handle(CustomerUpdatedEvent $event)
    {
        $customer = $event->customer;
        // Perform any additional actions or logging related to customer update
        Log::info('Customer updated: ' . $customer->id);
    }
}
