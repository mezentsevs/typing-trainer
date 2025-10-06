<?php

namespace Tests\Feature\Web;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    private const string HOME_URI = '/';
    
    public function testApplicationReturnsSuccessfulResponse(): void
    {
        $response = $this->get(self::HOME_URI);

        $response->assertStatus(200);
    }
}
