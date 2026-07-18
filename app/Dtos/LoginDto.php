<?php

namespace App\Dtos;

class LoginDto extends BaseDto
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) {
    }
}
