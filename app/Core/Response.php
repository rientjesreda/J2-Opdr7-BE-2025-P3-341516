<?php

declare(strict_types=1);

namespace App\Core;

final class Response
{
    /**
     * @param array<string, mixed> $data
     */
    public function view(string $view, array $data = [], int $status = 200): void
    {
        http_response_code($status);
        extract($data, EXTR_SKIP);
        require __DIR__ . '/../Views/layout.php';
    }

    public function redirect(string $location): never
    {
        header('Location: ' . $location);
        exit;
    }
}
