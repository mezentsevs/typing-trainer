<?php

namespace Tests\Feature\Services;

use App\Services\WordGeneration\WordCharDataProvider;
use App\Services\WordService;
use PHPUnit\Framework\Attributes\DataProviderExternal;
use Tests\Providers\WordDataProvider;
use Tests\TestCase;

class WordServiceTest extends TestCase
{
    protected WordService $service;

    protected const int MAX_EXTRA_SPECIAL_CHARS_COUNT = 2;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(WordService::class);
    }

    #[DataProviderExternal(WordDataProvider::class, 'provideWordGenerationData')]
    public function testGeneratedWordHasValidLength(array $data): void
    {
        $word = $this->service->generateWord($data['language'], $data['availableChars'], $data['newChars']);
        $wordLength = mb_strlen($word);

        $this->assertIsString($word);
        $this->assertNotEmpty($word);
        $this->assertGreaterThanOrEqual(
            WordCharDataProvider::MIN_LETTERS_PART_LENGTH,
            $wordLength,
            "Word '{$word}' in language {$data['language']} is too short.",
        );
        $this->assertLessThanOrEqual(
            WordCharDataProvider::MAX_LETTERS_PART_LENGTH + self::MAX_EXTRA_SPECIAL_CHARS_COUNT,
            $wordLength,
            "Word '{$word}' in language {$data['language']} is too long.",
        );
    }

    #[DataProviderExternal(WordDataProvider::class, 'provideWordGenerationData')]
    public function testGeneratedWordContainsOnlyAvailableChars(array $data): void
    {
        $word = $this->service->generateWord($data['language'], $data['availableChars'], $data['newChars']);

        $this->assertIsString($word);
        $this->assertNotEmpty($word);

        foreach (mb_str_split($word) as $char) {
            $this->assertContains(
                $char,
                $data['availableChars'],
                "Generated word contains invalid character '{$char}'. Available characters: " . implode(', ', $data['availableChars']) . '.',
            );
        }
    }

    #[DataProviderExternal(WordDataProvider::class, 'providePairedCharsData')]
    public function testGeneratedWordContainsPairedChars(array $data): void
    {
        $wordsWithPairedChars = [];

        for ($i = 0; $i < 100; $i++) {
            $word = $this->service->generateWord($data['language'], $data['availableChars'], $data['newChars']);

            if (mb_strpos($word, $data['openingChar']) !== false) {
                $wordsWithPairedChars[] = $word;
            }
        }

        $this->assertGreaterThan(
            0,
            count($wordsWithPairedChars),
            "No words generated with opening char '{$data['openingChar']}' for language {$data['language']}.",
        );

        foreach ($wordsWithPairedChars as $word) {
            $this->assertStringStartsWith(
                $data['openingChar'],
                $word,
                "Word '{$word}' does not start with opening char '{$data['openingChar']}' for language {$data['language']}.",
            );
            $this->assertStringEndsWith(
                $data['closingChar'],
                $word,
                "Word '{$word}' does not end with closing char '{$data['closingChar']}' for language {$data['language']}.",
            );
        }
    }
}
