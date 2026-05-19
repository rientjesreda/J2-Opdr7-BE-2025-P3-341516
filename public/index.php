<?php

declare(strict_types=1);

use App\Controllers\InstructorController;
use App\Controllers\VehicleController;
use App\Core\Container;
use App\Core\Request;
use App\Core\Response;
use App\Core\Router;

$container = require __DIR__ . '/../bootstrap.php';

$container->set(InstructorController::class, static fn (Container $container): InstructorController => new InstructorController(
    $container->get(\App\Models\InstructorRepository::class),
    $container->get(Response::class),
    $container->get('config.app')
));

$container->set(VehicleController::class, static fn (Container $container): VehicleController => new VehicleController(
    $container->get(\App\Models\InstructorRepository::class),
    $container->get(\App\Models\VehicleRepository::class),
    $container->get(\App\Services\VehicleService::class),
    $container->get(Response::class),
    $container->get('config.app')
));

$router = $container->get(Router::class);

$router->get('/', static fn (Container $container): mixed => $container->get(Response::class)->redirect('/instructors'));
$router->get('/instructors', static fn (Container $container, Request $request): mixed => $container->get(InstructorController::class)->index($request));
$router->get('/vehicles', static fn (Container $container, Request $request): mixed => $container->get(VehicleController::class)->assigned($request));
$router->get('/vehicles/available', static fn (Container $container, Request $request): mixed => $container->get(VehicleController::class)->available($request));
$router->get('/vehicles/edit', static fn (Container $container, Request $request): mixed => $container->get(VehicleController::class)->edit($request));
$router->post('/vehicles/update', static fn (Container $container, Request $request): mixed => $container->get(VehicleController::class)->update($request));

try {
    $router->dispatch($container->get(Request::class));
} catch (Throwable $exception) {
    http_response_code(500);
    echo '<h1>Er is iets misgegaan</h1>';
    echo '<pre>' . htmlspecialchars($exception->getMessage(), ENT_QUOTES, 'UTF-8') . '</pre>';
}
