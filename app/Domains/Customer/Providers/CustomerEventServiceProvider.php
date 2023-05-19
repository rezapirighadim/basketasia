<?php

namespace App\Domains\Customer\Providers;

use App\Domains\Customer\Events\CustomerCreatedEvent;
use App\Domains\Customer\Events\CustomerDeletedEvent;
use App\Domains\Customer\Events\CustomerUpdatedEvent;
use App\Domains\Customer\Listeners\CustomerCreatedListener;
use App\Domains\Customer\Listeners\CustomerDeletedListener;
use App\Domains\Customer\Listeners\CustomerUpdatedListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class CustomerEventServiceProvider extends ServiceProvider
{
    protected $listen = [
        CustomerCreatedEvent::class => [
            CustomerCreatedListener::class
        ],
        CustomerUpdatedEvent::class => [
            CustomerUpdatedListener::class
        ],
        CustomerDeletedEvent::class => [
            CustomerDeletedListener::class
        ],
    ];
}
