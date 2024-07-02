<?php

namespace Modules\Auth\DTO;

final readonly class UserDTO
{
    public function __construct(
        public int $id,
        public string $username,
        public string $email,
        public string $password,
        public string $createdAt,
    ) {
    }

}
