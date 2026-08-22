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

class IdTestSeeder extends LanguageTestSeeder
{
    public function getLanguageCode(): string
    {
        return 'id';
    }

    public function getTexts(): array
    {
        return [
            [
                'genre' => 'fiction',
                'text' => 'Mercusuar tua itu telah berdiri selama seratus tahun di atas tebing yang ditinggalkan. Ketika Mara mendorong pintu besi yang berat, terdengar keluhan panjang, seolah-olah bangunan itu sendiri terbangun.',
            ],
            [
                'genre' => 'non-fiction',
                'text' => 'Energi terbarukan memainkan peran penting dalam perjuangan melawan perubahan iklim. Panel surya dan turbin angin menghasilkan listrik bersih, sementara teknologi penyimpanan modern menstabilkan pasokan.',
            ],
            [
                'genre' => 'poetry',
                'text' => <<<EOT
                    Angin berbisik melalui rerumputan tinggi,
                    matahari melukis lembah dengan emas.
                    Sungai kecil yang tenang, belaian lembut,
                    bumi menjaga waktu dalam pelukannya.
                    EOT,
            ],
        ];
    }
}
