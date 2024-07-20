<?php

namespace Modules\Auth\Services\JWT\Contract;

interface JwtProviderInterface
{
    public function generateToken(array $payload): string;

    public function validateToken(string $token): array|false;
}
