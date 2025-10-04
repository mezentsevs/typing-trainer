<?php

namespace App\Helpers;

use Illuminate\Support\Str;

class StringHelper
{
    public static function normalize(string $rawString, string $encoding = 'UTF-8'): string
    {
        $s = self::normalizeEncoding($rawString, $encoding);
        $s = self::removeTags($s);
        $s = self::escapeSpecialChars($s, $encoding);
        $s = self::removeHtmlEntities($s);
        $s = self::removeDoubleSpaces($s);
        $s = self::removeDoubleNewLines($s);
        $s = self::replaceCurlyApostrophe($s);
        $s = self::replaceQuotes($s);
        $s = self::replaceDashes($s);
        $s = self::trimString($s);
        $s = self::normalizeNewLines($s);
        $s = self::capitalizeEachLine($s);

        return $s;
    }

    private static function normalizeEncoding(string $rawString, string $encoding): string
    {
        $detectedEncoding = mb_detect_encoding($rawString, ['UTF-8', 'Windows-1251', 'ISO-8859-1'], true);

        if (!$detectedEncoding) {
            return '';
        }

        return $detectedEncoding !== $encoding
            ? mb_convert_encoding($rawString, $encoding, $detectedEncoding)
            : $rawString;
    }

    private static function removeTags(string $string): string
    {
        return strip_tags($string);
    }

    private static function escapeSpecialChars(string $string, string $encoding): string
    {
        return htmlspecialchars($string, ENT_QUOTES | ENT_HTML5, $encoding);
    }

    private static function removeHtmlEntities(string $string): string
    {
        return preg_replace('/&[a-z]+;/i', '', $string);
    }

    private static function removeDoubleSpaces(string $string): string
    {
        return str_replace('  ', '', $string);
    }

    private static function removeDoubleNewLines(string $string): string
    {
        return str_replace("\n\n", "\n", $string);
    }

    private static function replaceCurlyApostrophe(string $string): string
    {
        return str_replace('’', "'", $string);
    }

    private static function replaceQuotes(string $string): string
    {
        return str_replace(['“', '”', '«', '»'], '"', $string);
    }

    private static function replaceDashes(string $string): string
    {
        return str_replace(['—', '–'], '-', $string);
    }

    private static function trimString(string $string): string
    {
        return trim($string);
    }

    private static function normalizeNewLines(string $string): string
    {
        return str_replace("\r\n", "\n", $string);
    }

    private static function capitalizeEachLine(string $string): string
    {
        $lines = explode("\n", $string);
        $capitalizedLines = array_map(function (string $line) {
            return Str::ucfirst($line);
        }, $lines);

        return implode("\n", $capitalizedLines);
    }
}
