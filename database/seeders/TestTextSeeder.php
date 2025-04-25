<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TestText;

class TestTextSeeder extends Seeder
{
    public function run(): void
    {
        $texts = [
            'en' => [
                [
                    'genre' => 'fiction',
                    'text' => 'In the year 2247, humanity had colonized the stars, but the frontier planet of Xerion was unlike any other. Its crimson skies shimmered with electromagnetic storms, and the native flora pulsed with bioluminescent energy. Captain Elena Voss led her crew through the dense jungle, their suits humming with protective shields. The mission was simple: retrieve the lost artifact said to control time itself. But as they ventured deeper, the jungle seemed to whisper, bending their perception of reality. Shadows moved unnaturally, and the air grew heavy with an unspoken warning. Would they find the artifact, or become lost in Xerion’s endless maze?',
                ],
            ],
            'ru' => [
                [
                    'genre' => 'fiction',
                    'text' => 'Туман окутывал старый особняк на окраине города, где произошло загадочное убийство. Детектив Анна Коваленко внимательно осматривала комнату: разбитое зеркало, перевернутый стул и следы крови на паркете. Жертва, богатый промышленник, был найден мертвым без единой улики, указывающей на убийцу. Анна заметила странный узор на обоях — едва различимый код, который мог быть ключом к разгадке. В доме оставались только трое: дворецкий, молодая наследница и таинственный гость. Каждый из них скрывал свои мотивы, и Анна знала: время на исходе, а убийца все еще здесь...',
                ],
            ],
        ];

        foreach ($texts as $language => $languageTexts) {
            foreach ($languageTexts as $textData) {
                TestText::create([
                    'language' => $language,
                    'genre' => $textData['genre'],
                    'text' => $textData['text'],
                ]);
            }
        }
    }
}
