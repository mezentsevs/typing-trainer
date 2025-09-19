<?php

namespace Tests\Providers;

class AuthDataProvider
{
    public static function provideValidFormatNames(): array
    {
        return [
            'with letters only' => ['John'],
            'with spaces' => ['John Doe'],
            'with hyphens' => ['John-Doe'],
            'with numbers' => ['John123'],
            'with all valid characters' => ['John-V Doe 123'],
        ];
    }

    public static function provideInvalidFormatNames(): array
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
}
