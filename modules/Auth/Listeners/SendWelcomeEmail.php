<?php

namespace Modules\Auth\Listeners;

use Illuminate\Support\Facades\Log;
use Modules\Auth\Events\UserSignedUp;

class SendWelcomeEmail
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(UserSignedUp $event): void
    {
        Log::info('email to: '.$event->user->email.' has been send!');
    }
}
