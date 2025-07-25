<?php

namespace App\Helpers;

class StringHelper
{
    public static function sanitize(string $rawString, string $encoding = 'UTF-8'): string
    {
        $detectedEncoding = mb_detect_encoding($rawString, ['UTF-8', 'Windows-1251', 'ISO-8859-1'], true);

        if (!$detectedEncoding) {
            return '';
        }

        $result = $detectedEncoding !== $encoding
            ? mb_convert_encoding($rawString, $encoding, $detectedEncoding)
            : $rawString;

        return str_replace("\r\n", "\n", trim(htmlspecialchars(strip_tags($result), ENT_QUOTES | ENT_HTML5, $encoding)));
    }
}
