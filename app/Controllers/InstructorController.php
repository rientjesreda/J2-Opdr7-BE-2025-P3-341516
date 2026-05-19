<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\InstructorRepository;

final class InstructorController extends Controller
{
    /**
     * @param array<string, mixed> $config
     */
    public function __construct(
        private readonly InstructorRepository $instructorRepository,
        private readonly Response $response,
        private readonly array $config
    ) {
    }

    public function index(Request $request): void
    {
        $page = max(1, (int) $request->query('page', 1));
        $perPage = 4;
        $total = $this->instructorRepository->countActive();

        $this->render($this->response, 'instructors/index', [
            'view' => 'instructors/index',
            'app' => $this->config,
            'title' => 'Instructeurs in dienst',
            'instructors' => $this->instructorRepository->paginate($page, $perPage),
            'page' => $page,
            'perPage' => $perPage,
            'total' => $total,
            'flash' => (string) $request->query('message', ''),
        ]);
    }
}
