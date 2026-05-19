<?php

declare(strict_types=1);

namespace App\Core;

use RuntimeException;

final class Router
{
    /** @var array<string, array<string, callable>> */
    private array $routes = [];

    public function __construct(
        private readonly Container $container
    ) {
    }

    public function get(string $path, callable $handler): void
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post(string $path, callable $handler): void
    {
        $this->routes['POST'][$path] = $handler;
    }

    public function dispatch(Request $request): void
    {
        $method = $request->method();
        $path = rtrim($request->path(), '/') ?: '/';
        $handler = $this->routes[$method][$path] ?? null;

        if (! is_callable($handler)) {
            throw new RuntimeException("Route niet gevonden: {$method} {$path}");
        }

        $handler($this->container, $request);
    }
}
