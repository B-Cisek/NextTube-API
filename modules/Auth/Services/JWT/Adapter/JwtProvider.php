<?php

namespace Modules\Auth\Services\JWT\Adapter;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use LogicException;
use Modules\Auth\Services\JWT\Contract\JwtProviderInterface;
use UnexpectedValueException;

final readonly class JwtProvider implements JwtProviderInterface
{
    public function __construct(
        private string $privateKey,
        private string $publicKey,
        private array $payload,
        private string $algorithm
    ) {}

    public function generateToken(array $payload): string
    {
        $payload = [...$this->payload, ...$payload];

        return JWT::encode($payload, $this->privateKey, $this->algorithm);
    }

    public function validateToken(string $token, ?array $headers = null): array|false
    {
        try {
            $decoded = JWT::decode($token, new Key($this->publicKey, $this->algorithm), $headers);
        } catch (LogicException $e) {
            // errors having to do with environmental setup or malformed JWT Keys
            dd($e->getMessage());

            return false;
        } catch (UnexpectedValueException $e) {
            // errors having to do with JWT signature and claims
            dd($e->getMessage());

            return false;
        }

        return (array) $decoded;
    }
}
