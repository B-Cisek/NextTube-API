<?php

namespace Modules\Auth\Exceptions;

class ThrottleException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
