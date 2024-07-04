<?php

namespace Modules\Shared\Services\Notification\Decorator;

use Modules\Shared\Services\Notification\Contract\NotificationInterface;

class NotificationDecorator implements NotificationInterface
{
    public function __construct(
        private readonly NotificationInterface $notification,
    ) {}

    public function send(string $message): string
    {
        return $this->notification->send($message);
    }
}
