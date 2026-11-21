<?php

namespace App\Dtos;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use ReflectionClass;

abstract class BaseDto
{
    public static function fromArray(array $data): static
    {
        return new static(...static::buildArgs(fn (string $name) => $data[$name] ?? null));
    }

    public static function fromRequest(Request $request): static
    {
        return new static(...static::buildArgs(function (string $name) use ($request) {
            if ($name === 'userId') {
                return $request->user()->id;
            }

            $key = Str::snake($name);

            return $request->filled($key) ? $request->{$key} : null;
        }));
    }

    public function toAttributes(): array
    {
        return Arr::mapWithKeys(get_object_vars($this), fn ($value, $key) => [Str::snake($key) => $value]);
    }

    private static function buildArgs(callable $resolver): array
    {
        $reflection = new ReflectionClass(static::class);
        $parameters = $reflection->getConstructor()?->getParameters() ?? [];
        $args = [];

        foreach ($parameters as $parameter) {
            $args[] = $resolver($parameter->getName());
        }

        return $args;
    }
}
