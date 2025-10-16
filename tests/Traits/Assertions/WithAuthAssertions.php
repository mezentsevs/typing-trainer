<?php

namespace Tests\Traits\Assertions;

use Tests\Traits\Constants\WithAuthConstants;

trait WithAuthAssertions
{
    use WithResponseAssertions, WithAuthConstants;

    protected function assertRegistrationSuccessful(): static
    {
        $this->assertStatusWithJsonStructure(201, [
            'token',
            'user' => self::REGISTER_RESPONSE_USER_JSON_STRUCTURE,
        ]);

        return $this;
    }

    protected function assertLoginSuccessful(): static
    {
        $this->assertStatusWithJsonStructure(200, [
            'token',
            'user' => self::LOGIN_RESPONSE_USER_JSON_STRUCTURE,
        ]);

        return $this;
    }
}
