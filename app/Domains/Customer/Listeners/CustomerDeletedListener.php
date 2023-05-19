<?php

namespace App\Domains\Customer\Listeners;

use App\Domains\Customer\Events\CustomerDeletedEvent;
use Illuminate\Support\Facades\Log;

class CustomerDeletedListener
{
    public function handle(CustomerDeletedEvent $event)
    {
        $customer = $event->customer;
        // Perform any additional actions or logging related to customer deletion
        Log::info('Customer deleted: ' . $customer->id);
    }
}
