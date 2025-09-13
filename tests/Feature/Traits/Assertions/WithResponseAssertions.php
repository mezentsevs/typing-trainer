<?php

namespace Tests\Feature\Traits\Assertions;

use Illuminate\Testing\TestResponse;

trait WithResponseAssertions
{
    protected TestResponse $response;

    protected function withResponse(TestResponse $response): static
    {
        $this->response = $response;

        return $this;
    }

    protected function assertStatusWithMessage(int $status, string $message): static
    {
        $this->response
            ->assertStatus($status)
            ->assertJson([
                'message' => $message,
            ]);

        return $this;
    }

    protected function assertStatusWithErrorAndMessage(int $status, string $error, string $message): static
    {
        $this->assertStatusWithMessage($status, $message);

        $this->response
            ->assertJson([
                'errors' => [
                    $error => [$message],
                ],
            ]);

        return $this;
    }
}
