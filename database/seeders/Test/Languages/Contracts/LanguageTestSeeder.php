<?php

namespace Database\Seeders\Test\Languages\Contracts;

use App\Models\Test;
use Illuminate\Database\Seeder;

abstract class LanguageTestSeeder extends Seeder
{
    abstract public function getLanguageCode(): string;

    abstract public function getTexts(): array;

    public function run(): void
    {
        $languageCode = $this->getLanguageCode();

        foreach ($this->getTexts() as $data) {
            Test::create([
                'language' => $languageCode,
                'genre' => $data['genre'],
                'text' => $data['text'],
            ]);
        }
    }
}
