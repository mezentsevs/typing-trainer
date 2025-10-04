<?php

namespace App\Helpers;

class StringHelper
{
    public static function normalize(string $rawString, string $encoding = 'UTF-8'): string
    {
        $result = self::normalizeEncoding($rawString, $encoding);
        $result = self::removeTags($result);
        $result = self::removeDoubleSpaces($result);
        $result = self::removeDoubleNewLines($result);
        $result = self::replaceCurlyApostrophe($result);
        $result = self::replaceQuotes($result);
        $result = self::replaceDashes($result);
        $result = self::escapeSpecialChars($result, $encoding);
        $result = self::removeHtmlEntities($result);
        $result = self::trimString($result);
        $result = self::normalizeNewLines($result);

        return $result;
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

    private static function escapeSpecialChars(string $string, string $encoding): string
    {
        return htmlspecialchars($string, ENT_QUOTES | ENT_HTML5, $encoding);
    }

    private static function removeHtmlEntities(string $string): string
    {
        return preg_replace('/&[a-z]+;/i', '', $string);
    }

    private static function trimString(string $string): string
    {
        return trim($string);
    }

    private static function normalizeNewLines(string $string): string
    {
        return str_replace("\r\n", "\n", $string);
    }
}
