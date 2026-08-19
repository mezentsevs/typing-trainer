<?php

namespace Database\Seeders\Test;

use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    public function run(): void
    {
        foreach (app()->tagged('languageTestSeeders') as $seeder) {
            $seeder->run();
        }
    }
}
