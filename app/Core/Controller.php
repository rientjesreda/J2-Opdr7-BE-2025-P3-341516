<?php

declare(strict_types=1);

namespace App\Core;

abstract class Controller
{
    /**
     * @param array<string, mixed> $data
     */
    protected function render(Response $response, string $view, array $data = [], int $status = 200): void
    {
        $response->view($view, $data, $status);
    }
}
