<?php

namespace App\Dtos;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use ReflectionClass;

abstract class BaseDto
{
    public static function fromArray(array $data): static
    {
        $reflection = new ReflectionClass(static::class);
        $parameters = $reflection->getConstructor()?->getParameters() ?? [];
        $args = [];

        foreach ($parameters as $param) {
            $name = $param->getName();
            $args[] = $data[$name] ?? null;
        }

        return new static(...$args);
    }

    public function toAttributes(): array
    {
        return Arr::mapWithKeys(get_object_vars($this), fn ($value, $key) => [Str::snake($key) => $value]);
    }
}
