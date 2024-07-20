<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected const string SUCCESS = 'success';

    protected const string ERROR = 'error';

    protected static function success(array $data = [], int $status = 200, array $headers = [], int $options = 0): array
    {
        return [
            ['status' => self::SUCCESS, ...$data],
            $status,
            $headers,
            $options,
        ];
    }

    protected static function error(array $data = [], int $status = 400, array $headers = [], int $options = 0): array
    {
        return [
            ['status' => self::ERROR, ...$data],
            $status,
            $headers,
            $options,
        ];
    }
}
