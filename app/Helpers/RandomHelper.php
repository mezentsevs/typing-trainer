<?php

namespace App\Helpers;

use Random\RandomException;

class RandomHelper
{
    /**
     * @throws RandomException
     */
    public static function flipCoin(): bool
    {
        return random_int(0, 1) === 0;
    }

    /**
     * @throws RandomException
     */
    public static function rollChance(int $chance): bool
    {
        return random_int(0, 99) < $chance;
    }
}
