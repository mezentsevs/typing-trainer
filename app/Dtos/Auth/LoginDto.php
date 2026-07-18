<?php

namespace App\Dtos\Auth;

use App\Dtos\BaseDto;

class LoginDto extends BaseDto
{
    public function __construct(
        public readonly string $email,
        public readonly string $password,
    ) {
    }
}
