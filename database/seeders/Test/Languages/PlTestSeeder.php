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

class PlTestSeeder extends LanguageTestSeeder
{
    public function getLanguageCode(): string
    {
        return 'pl';
    }

    public function getTexts(): array
    {
        return [
            [
                'genre' => 'fiction',
                'text' => 'Stara latarnia morska stała od stu lat na opuszczonym klifie. Gdy Mara pchnęła ciężkie żelazne drzwi, rozległo się głębokie westchnienie, jakby budynek sam się obudził.',
            ],
            [
                'genre' => 'non-fiction',
                'text' => 'Energia odnawialna odgrywa kluczową rolę w walce ze zmianami klimatu. Panele słoneczne i turbiny wiatrowe dostarczają czystą energię, a nowoczesne magazyny stabilizują dostawy.',
            ],
            [
                'genre' => 'poetry',
                'text' => <<<EOT
                    Wiatr szepcze wśród wysokich traw,
                    słońce maluje dolinę złotem.
                    Cichy strumień, delikatna pieszczota,
                    ziemia trzyma czas w swym uścisku.
                    EOT,
            ],
        ];
    }
}
