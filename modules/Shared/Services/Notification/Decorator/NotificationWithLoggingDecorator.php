<?php

namespace Modules\Shared\Services\Notification\Decorator;

use Modules\Shared\Services\Notification\Contract\NotificationInterface;
use Psr\Log\LoggerInterface;

class NotificationWithLoggingDecorator implements NotificationInterface
{
    public function __construct(
        private readonly NotificationInterface $notification,
        private readonly LoggerInterface $logger,
    ) {}

    public function send(string $message): string
    {
        $this->log('Sending notification: '.$message);

        return $this->notification->send($message);
    }

    private function log(string $message): void
    {
        $this->logger->notice($message);
    }
}
