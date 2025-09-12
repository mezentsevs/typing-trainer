<?php

namespace Tests\Feature\Traits;

use Illuminate\Testing\TestResponse;

trait WithResponseAssertions
{
    protected TestResponse $response;

    protected function withResponse(TestResponse $response): static
    {
        $this->response = $response;

        return $this;
    }

    protected function assertStatusWithErrorAndMessage(int $status, string $error, string $message): void
    {
        $this->response
            ->assertStatus($status)
            ->assertJson([
                'message' => $message,
                'errors' => [
                    $error => [$message],
                ],
            ]);
    }
}
