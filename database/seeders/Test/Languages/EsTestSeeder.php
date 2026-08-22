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

class EsTestSeeder extends LanguageTestSeeder
{
    public function getLanguageCode(): string
    {
        return 'es';
    }

    public function getTexts(): array
    {
        return [
            [
                'genre' => 'fiction',
                'text' => 'El viejo faro llevaba cien años abandonado en el acantilado. Cuando Mara empujó la pesada puerta de hierro, un profundo suspiro resonó, como si el edificio despertara.',
            ],
            [
                'genre' => 'non-fiction',
                'text' => 'Las energías renovables desempeñan un papel central en la lucha contra el cambio climático. La energía solar y la eólica proporcionan electricidad limpia, mientras que las tecnologías de almacenamiento estabilizan el suministro.',
            ],
            [
                'genre' => 'poetry',
                'text' => <<<EOT
                    El viento susurra entre la hierba alta,
                    el sol pinta el valle de oro.
                    Un arroyo silencioso, una suave caricia,
                    la tierra guarda el tiempo en su decoro.
                    EOT,
            ],
        ];
    }
}
