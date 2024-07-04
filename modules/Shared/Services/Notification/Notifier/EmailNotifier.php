<?php

namespace Modules\Shared\Services\Notification\Notifier;

use Modules\Shared\Services\Notification\Contract\NotificationInterface;

class EmailNotifier implements NotificationInterface
{
    public function send(string $message): string
    {
        return 'Email: '.$message;
    }
}
