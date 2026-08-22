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

class ItTestSeeder extends LanguageTestSeeder
{
    public function getLanguageCode(): string
    {
        return 'it';
    }

    public function getTexts(): array
    {
        return [
            [
                'genre' => 'fiction',
                'text' => 'Il vecchio faro sorgeva da cento anni sulla scogliera abbandonata. Quando Mara spinse la pesante porta di ferro, si udì un profondo sospiro, come se l\'edificio stesso si risvegliasse.',
            ],
            [
                'genre' => 'non-fiction',
                'text' => 'Le energie rinnovabili svolgono un ruolo centrale nella lotta contro il cambiamento climatico. I pannelli solari e le turbine eoliche forniscono elettricità pulita, mentre le tecnologie di stoccaggio stabilizzano l\'approvvigionamento.',
            ],
            [
                'genre' => 'poetry',
                'text' => <<<EOT
                    Il vento sussurra tra l\'erba alta,
                    il sole dipinge la valle d\'oro.
                    Un ruscello silenzioso, una dolce carezza,
                    la terra custodisce il tempo nel suo decoro.
                    EOT,
            ],
        ];
    }
}
