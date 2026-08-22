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

class PtTestSeeder extends LanguageTestSeeder
{
    public function getLanguageCode(): string
    {
        return 'pt';
    }

    public function getTexts(): array
    {
        return [
            [
                'genre' => 'fiction',
                'text' => 'O velho farol permanecia há cem anos no penhasco abandonado. Quando Mara empurrou a pesada porta de ferro, um suspiro profundo ecoou, como se o próprio edifício despertasse.',
            ],
            [
                'genre' => 'non-fiction',
                'text' => 'As energias renováveis desempenham um papel central na luta contra as mudanças climáticas. Painéis solares e turbinas eólicas fornecem eletricidade limpa, enquanto tecnologias de armazenamento estabilizam o abastecimento.',
            ],
            [
                'genre' => 'poetry',
                'text' => <<<EOT
                    O vento sussurra entre a relva alta,
                    o sol pinta o vale de dourado.
                    Um riacho silencioso, uma carícia suave,
                    a terra guarda o tempo em seu cuidado.
                    EOT,
            ],
        ];
    }
}
