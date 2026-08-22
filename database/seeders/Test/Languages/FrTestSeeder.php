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

class FrTestSeeder extends LanguageTestSeeder
{
    public function getLanguageCode(): string
    {
        return 'fr';
    }

    public function getTexts(): array
    {
        return [
            [
                'genre' => 'fiction',
                'text' => 'Le vieux phare se dressait depuis cent ans sur la falaise abandonnée. Lorsque Mara poussa la lourde porte de fer, un profond soupir résonna, comme si le bâtiment lui-même séveillait.',
            ],
            [
                'genre' => 'non-fiction',
                'text' => 'Les énergies renouvelables jouent un rôle central dans la lutte contre le changement climatique. Les panneaux solaires et les éoliennes fournissent une électricité propre, tandis que les technologies de stockage stabilisent l\'approvisionnement.',
            ],
            [
                'genre' => 'poetry',
                'text' => <<<EOT
                    Le vent murmure à travers les herbes hautes,
                    le soleil peint la vallée en or.
                    Un ruisseau silencieux, une douce caresse,
                    la terre garde le temps dans son décor.
                    EOT,
            ],
        ];
    }
}
