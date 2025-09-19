<?php

namespace Tests\Providers;

class AuthDataProvider
{
    protected const string NUMBERS = '0123456789';
    protected const string SPECIAL_CHARS = '!@#$%^&*()_+-=[]{}|;:\"\',.<>/?~`';

    public static function provideValidFormatUserNames(): array
    {
        return [
            'with letters only' => ['John'],
            'with spaces' => ['John Doe'],
            'with hyphens' => ['John-Doe'],
            'with numbers' => ['John' . self::NUMBERS],
            'with all valid characters' => ['John-V Doe ' . self::NUMBERS],
        ];
    }

    public static function provideInvalidFormatUserNames(): array
    {
        return [
            'with ampersand' => ['John&Doe'],
            'with apostrophe' => ["John'O'Doe"],
            'with asterisk' => ['John*Doe'],
            'with at sign' => ['John@Doe'],
            'with backslash' => ['John\Doe'],
            'with backtick' => ['John`Doe'],
            'with caret' => ['John^Doe'],
            'with closing bracket' => ['John]Doe'],
            'with closing curly brace' => ['John}Doe'],
            'with closing parenthesis' => ['John)Doe'],
            'with colon' => ['John:Doe'],
            'with comma' => ['John,Doe'],
            'with dollar sign' => ['John$Doe'],
            'with dot' => ['John.Doe'],
            'with equals' => ['John=Doe'],
            'with exclamation mark' => ['John!Doe'],
            'with greater than' => ['John>Doe'],
            'with hash' => ['John#Doe'],
            'with less than' => ['John<Doe'],
            'with opening bracket' => ['John[Doe'],
            'with opening curly brace' => ['John{Doe'],
            'with opening parenthesis' => ['John(Doe'],
            'with percent' => ['John%Doe'],
            'with pipe' => ['John|Doe'],
            'with plus' => ['John+Doe'],
            'with question mark' => ['John?Doe'],
            'with quotes' => ['John"Doe'],
            'with semicolon' => ['John;Doe'],
            'with slash' => ['John/Doe'],
            'with tilde' => ['John~Doe'],
            'with underscore' => ['John_Doe'],

            'with cyrillic letters' => ['Иван Иванов'],
            'with german umlaut' => ['Jürgen Müller'],
            'with french accents' => ['René François'],
            'with japanese characters' => ['山田太郎'],
            'with arabic script' => ['محمد أحمد'],
        ];
    }

    public static function provideValidFormatPasswords(): array
    {
        return [
            'with letters only' => ['Password'],
            'with numbers' => ['Password' . self::NUMBERS],
            'with special characters' => ['Password' . self::SPECIAL_CHARS],
            'with all valid characters' => ['Password' . self::NUMBERS . self::SPECIAL_CHARS],
        ];
    }

    public static function provideInvalidFormatPasswords(): array
    {
        return [
            'with carriage return' => ["Pass\rword"],
            'with new line' => ["Pass\nword"],
            'with null character' => ["Pass\0word"],
            'with space' => ['Pass word'],
            'with tab' => ["Pass\tword"],

            'with cyrillic letters' => ['БезопасныйПароль'],
            'with german umlaut' => ['Passwörd'],
            'with french accents' => ['Môt-de-pässé'],
            'with japanese characters' => ['マイパスワードは安全です'],
            'with arabic script' => ['كلمةالمرور'],
        ];
    }
}
