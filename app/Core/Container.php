<?php

declare(strict_types=1);

namespace App\Core;

use RuntimeException;

final class Container
{
    /** @var array<string, callable(self): mixed> */
    private array $bindings = [];

    /** @var array<string, mixed> */
    private array $instances = [];

    public function set(string $id, callable $resolver): void
    {
        $this->bindings[$id] = $resolver;
    }

    public function get(string $id): mixed
    {
        if (array_key_exists($id, $this->instances)) {
            return $this->instances[$id];
        }

        if (! array_key_exists($id, $this->bindings)) {
            throw new RuntimeException("Geen binding gevonden voor {$id}");
        }

        return $this->instances[$id] = $this->bindings[$id]($this);
    }
}
