<?php

/*
 * Texts provided by this seeder (hereinafter referred to as "Content") were generated with AI assistance and have been
 * manually reviewed, corrected, and edited by the authors to fix errors and inaccuracies.
 *
 * Important notes:
 * - Content is provided exclusively for typing practice purposes;
 * - Content may contain fictional elements and does not claim complete accuracy;
 * - Content is not intended for factual reference, research, or professional use.
 *
 * Disclaimer: The authors are not responsible for any inaccuracies in the Content.
 */

namespace Database\Seeders\Test\Languages;

use Database\Seeders\Test\Languages\Contracts\LanguageTestSeeder;

class TrTestSeeder extends LanguageTestSeeder
{
    public function getLanguageCode(): string
    {
        return 'tr';
    }

    public function getTexts(): array
    {
        return [
            [
                'genre' => 'fiction',
                'text' => 'Eski deniz feneri yüz yıldır terk edilmiş kayalıkların üzerinde duruyordu. Mara ağır demir kapıyı ittiğinde derin bir iç çekiş duyuldu, sanki bina kendiliğinden uyanıyordu.',
            ],
            [
                'genre' => 'non-fiction',
                'text' => 'Yenilenebilir enerji, iklim değişikliğiyle mücadelede merkezi bir rol oynamaktadır. Güneş panelleri ve rüzgar türbinleri temiz elektrik sağlarken, modern depolama teknolojileri arzı dengeler.',
            ],
            [
                'genre' => 'poetry',
                'text' => <<<EOT
                    Rüzgar yüksek otların arasında fısıldar,
                    güneş vadiyi altına boyar.
                    Sessiz bir dere, yumuşak bir okşayış,
                    toprak zamanı kucağında saklar.
                    EOT,
            ],
        ];
    }
}
