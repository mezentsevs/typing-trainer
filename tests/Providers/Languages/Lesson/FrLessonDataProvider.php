<?php

namespace Tests\Providers\Languages\Lesson;

use App\Languages\FrLanguage;
use Tests\Providers\Languages\Lesson\Contracts\LanguageLessonDataProvider;

class FrLessonDataProvider extends LanguageLessonDataProvider
{
    protected const string LANGUAGE_CODE = FrLanguage::CODE;

    protected const string CHARS = 'qsdfghjklmù*azertyuiop$<wxcvbn,;:!éèçàâêîôûëïœQSDFGHJKLM%µAZERTYUIOP£>WXCVBN?./§ÉÈÇÀÙÂÊÎÔÛËÏŒ²&"\'(-_)=1234567890°+~#{[|`\\@]}€¤äöæüÿÄÖÆÜŸ';

    protected const array NEW_CHARS_SEQUENCE = [
        1 => 'qsdfghj',
        2 => 'klmù*aze',
        3 => 'rtyuiop$',
        4 => '<wxcvbn,',
        5 => ';:!éèçàâê',
        6 => 'îôûëïœQSDF',
        7 => 'GHJKLM%µAZ',
        8 => 'ERTYUIOP£>W',
        9 => 'XCVBN?./§ÉÈÇ',
        10 => 'ÀÙÂÊÎÔÛËÏŒ²&"',
        11 => '\'(-_)=12345678',
        12 => '90°+~#{[|`\\@]}€¤',
        13 => 'äöæüÿÄÖÆÜŸ',
        14 => self::CHARS,
        15 => self::CHARS,
        16 => self::CHARS,
        17 => self::CHARS,
        18 => self::CHARS,
        19 => self::CHARS,
        20 => self::CHARS,
    ];
}
