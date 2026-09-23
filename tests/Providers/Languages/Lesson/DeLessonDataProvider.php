<?php

namespace Tests\Providers\Languages\Lesson;

use App\Languages\DeLanguage;
use Tests\Providers\Languages\Lesson\Contracts\LanguageLessonDataProvider;

class DeLessonDataProvider extends LanguageLessonDataProvider
{
    protected const string LANGUAGE_CODE = DeLanguage::CODE;

    protected const string CHARS = 'asdfghjklöä#qwertzuiopü+<yxcvbnmß,.-ASDFGHJKLÖÄQWERTZUIOPÜ>YXCVBNMẞ1234567890!"§$%&/()=?°²³{[]}~|@€µ\\*;:_\'âêîôûáéíóúýàèìòùÂÊÎÔÛÁÉÍÓÚÝÀÈÌÒÙ';

    protected const array NEW_CHARS_SEQUENCE = [
        1 => 'asdfghj',
        2 => 'klöä#qwe',
        3 => 'rtzuiopü',
        4 => '+<yxcvbnm',
        5 => 'ß,.-ASDFG',
        6 => 'HJKLÖÄQWER',
        7 => 'TZUIOPÜ>YX',
        8 => 'CVBNMẞ12345',
        9 => '67890!"§$%&/',
        10 => '()=?°²³{[]}~|',
        11 => '@€µ\\*;:_\'âêîôû',
        12 => 'áéíóúýàèìòùÂÊÎÔÛ',
        13 => 'ÁÉÍÓÚÝÀÈÌÒÙ',
        14 => self::CHARS,
        15 => self::CHARS,
        16 => self::CHARS,
        17 => self::CHARS,
        18 => self::CHARS,
        19 => self::CHARS,
        20 => self::CHARS,
    ];
}
