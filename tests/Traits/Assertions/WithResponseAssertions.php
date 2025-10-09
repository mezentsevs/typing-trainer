<?php

namespace Tests\Traits\Assertions;

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

    protected function assertStatusWithHeaderNameAndValue(int $status, string $headerName, string $value): static
    {
        $this->response
            ->assertStatus($status)
            ->assertHeader($headerName, $value);

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

    protected function assertStatusWithJsonStructure(int $status, array $structure): static
    {
        $this->response
            ->assertStatus($status)
            ->assertJsonStructure($structure);

        return $this;
    }

    protected function assertStatusWithJsonStructureAndJson(int $status, array $structure, array $json): static
    {
        $this->response
            ->assertStatus($status)
            ->assertJsonStructure($structure)
            ->assertJson($json);

        return $this;
    }
}
