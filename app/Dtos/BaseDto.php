<?php

namespace App\Dtos;

abstract class BaseDto
{
    public static function fromArray(array $data): static
    {
        $reflection = new \ReflectionClass(static::class);
        $parameters = $reflection->getConstructor()?->getParameters() ?? [];
        $args = [];

        foreach ($parameters as $param) {
            $name = $param->getName();
            $args[] = $data[$name] ?? null;
        }

        return new static(...$args);
    }
}
