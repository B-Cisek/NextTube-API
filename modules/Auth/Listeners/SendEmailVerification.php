<?php

namespace Modules\Auth\Listeners;

use Illuminate\Auth\Events\Registered;
use Modules\Auth\Events\UserSignedUp;

class SendEmailVerification
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UserSignedUp $event): void
    {
        event(new Registered($event->user)); // Internal event for email verification
    }
}
