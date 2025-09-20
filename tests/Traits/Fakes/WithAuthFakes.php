<?php

namespace Tests\Traits\Fakes;

use Tests\Traits\Constants\WithAuthConstants;

trait WithAuthFakes
{
    use WithAuthConstants;

    protected function fakeValidLongUserName(): string
    {
        return str_repeat('a', static::MAX_USER_NAME_LENGTH);
    }

    protected function fakeInvalidLongUserName(): string
    {
        return str_repeat('a', static::MAX_USER_NAME_LENGTH + 1);
    }

    protected function fakeValidLongEmail(): string
    {
        return str_repeat('a', $this->calcMaxEmailLocalPartLength()) . static::EMAIL_DOMAIN;
    }

    protected function calcMaxEmailLocalPartLength(): int
    {
        return static::MAX_EMAIL_LENGTH - strlen(static::EMAIL_DOMAIN);
    }

    protected function fakeInvalidLongEmail(): string
    {
        return str_repeat('a', $this->calcMaxEmailLocalPartLength() + 1) . static::EMAIL_DOMAIN;
    }

    protected function fakeValidShortPassword(): string
    {
        return str_repeat('a', static::MIN_PASSWORD_LENGTH);
    }

    protected function fakeInvalidShortPassword(): string
    {
        return str_repeat('a', static::MIN_PASSWORD_LENGTH - 1);
    }

    protected function fakeValidLongPassword(): string
    {
        return str_repeat('a', static::MAX_PASSWORD_LENGTH);
    }

    protected function fakeInvalidLongPassword(): string
    {
        return str_repeat('a', static::MAX_PASSWORD_LENGTH + 1);
    }
}
