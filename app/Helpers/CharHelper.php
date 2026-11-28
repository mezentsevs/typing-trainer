<?php

namespace App\Helpers;

class CharHelper
{
    private const string PREG_ALPHANUMERIC = '/[\p{L}\p{N}]/u';
    private const string PREG_NUMERIC = '/\p{N}/u';

    public static function isAlphanumeric(string $char): bool
    {
        return preg_match(self::PREG_ALPHANUMERIC, $char) === 1;
    }

    public static function isNumeric(string $char): bool
    {
        return preg_match(self::PREG_NUMERIC, $char) === 1;
    }
}
