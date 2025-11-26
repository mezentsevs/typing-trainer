<?php

namespace Tests\Traits;

trait WithUri
{
    protected function normalizeUriForMessage(string $uri): string
    {
        return ltrim($uri, '/');
    }
}
