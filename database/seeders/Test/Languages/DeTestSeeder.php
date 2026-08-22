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

class DeTestSeeder extends LanguageTestSeeder
{
    public function getLanguageCode(): string
    {
        return 'de';
    }

    public function getTexts(): array
    {
        return [
            [
                'genre' => 'fiction',
                'text' => 'Der alte Leuchtturm stand seit hundert Jahren verlassen an der Klippe. Als Mara die schwere Eisentür aufstieß, erklang ein tiefes Seufzen, als ob das Gebäude selbst erwachte.',
            ],
            [
                'genre' => 'non-fiction',
                'text' => 'Erneuerbare Energien spielen eine zentrale Rolle im Kampf gegen den Klimawandel. Solaranlagen und Windkraft liefern sauberen Strom, während moderne Speichertechnologien die Versorgung stabilisieren.',
            ],
            [
                'genre' => 'poetry',
                'text' => <<<EOT
                    Der Wind flüstert durch das hohe Gras,
                    die Sonne malt das Tal in Gold.
                    Ein stiller Bach, ein sanftes Naß,
                    die Erde hält die Zeit im Sold.
                    EOT,
            ],
        ];
    }
}
