<?php

namespace Modules\Shared\Services\Notification\Contract;

interface NotificationInterface
{
    public function send(string $message): string;
}
