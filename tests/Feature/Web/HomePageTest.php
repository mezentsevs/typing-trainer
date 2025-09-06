<?php

namespace Tests\Feature\Web;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function testApplicationReturnsSuccessfulResponse(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
