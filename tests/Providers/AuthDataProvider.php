<?php

namespace Tests\Providers;

class AuthDataProvider
{
    protected const string NUMBERS = '0123456789';
    protected const string SPECIAL_CHARS = '!@#$%^&*()_+-=[]{}|;:\"\',.<>/?~`';

    public static function provideValidUserNames(): array
    {
        return [
            'letters only' => ['John'],
            'space' => ['John Doe'],
            'hyphen' => ['John-Doe'],
            'numbers' => ['John' . self::NUMBERS],
            'all valid' => ['John-V Doe ' . self::NUMBERS],
        ];
    }

    public static function provideInvalidUserNames(): array
    {
        return [
            'ampersand' => ['John&Doe'],
            'apostrophe' => ["John'Doe"],
            'asterisk' => ['John*Doe'],
            'at sign' => ['John@Doe'],
            'backslash' => ['John\Doe'],
            'backtick' => ['John`Doe'],
            'caret' => ['John^Doe'],
            'closing bracket' => ['John]Doe'],
            'closing curly brace' => ['John}Doe'],
            'closing parenthesis' => ['John)Doe'],
            'colon' => ['John:Doe'],
            'comma' => ['John,Doe'],
            'dollar sign' => ['John$Doe'],
            'dot' => ['John.Doe'],
            'equals' => ['John=Doe'],
            'exclamation mark' => ['John!Doe'],
            'greater than' => ['John>Doe'],
            'hash' => ['John#Doe'],
            'less than' => ['John<Doe'],
            'opening bracket' => ['John[Doe'],
            'opening curly brace' => ['John{Doe'],
            'opening parenthesis' => ['John(Doe'],
            'percent' => ['John%Doe'],
            'pipe' => ['John|Doe'],
            'plus' => ['John+Doe'],
            'question mark' => ['John?Doe'],
            'quote' => ['John"Doe'],
            'semicolon' => ['John;Doe'],
            'slash' => ['John/Doe'],
            'tilde' => ['John~Doe'],
            'underscore' => ['John_Doe'],

            'arabic' => ['محمد أحمد'],
            'cyrillic' => ['Иван Иванов'],
            'french' => ['René François'],
            'german' => ['Jürgen Müller'],
            'japanese' => ['山田太郎'],

            'carriage return' => ["John\rDoe"],
            'form feed' => ["John\fDoe"],
            'new line' => ["John\nDoe"],
            'null character' => ["John\0Doe"],
            'tab' => ["John\tDoe"],
            'vertical tab' => ["John\vDoe"],
        ];
    }

    public static function provideValidPasswords(): array
    {
        return [
            'letters only' => ['Password'],
            'numbers' => ['Password' . self::NUMBERS],
            'special' => ['Password' . self::SPECIAL_CHARS],
            'all valid' => ['Password' . self::NUMBERS . self::SPECIAL_CHARS],
        ];
    }

    public static function provideInvalidPasswords(): array
    {
        return [
            'arabic' => ['كلمةالمرور'],
            'cyrillic' => ['БезопасныйПароль'],
            'french' => ['SécuriséMotDePasse'],
            'german' => ['Passwörd'],
            'japanese' => ['マイパスワードは安全です'],

            'carriage return' => ["Pass\rword"],
            'form feed' => ["Pass\fword"],
            'new line' => ["Pass\nword"],
            'null character' => ["Pass\0word"],
            'space' => ['Pass word'],
            'tab' => ["Pass\tword"],
            'vertical tab' => ["Pass\vword"],
        ];
    }
}
