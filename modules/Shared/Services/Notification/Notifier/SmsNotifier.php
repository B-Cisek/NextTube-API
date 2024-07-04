<?php

namespace Modules\Shared\Services\Notification\Notifier;

use Modules\Shared\Services\Notification\Contract\NotificationInterface;

class SmsNotifier implements NotificationInterface
{
    public function send(string $message): string
    {
        // TODO: Implement send() method.
    }
}
