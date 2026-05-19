<?php

declare(strict_types=1);

use App\Core\Container;
use App\Core\Database;
use App\Core\Request;
use App\Core\Response;
use App\Core\Router;
use App\Models\InstructorRepository;
use App\Models\VehicleRepository;
use App\Services\VehicleService;

require __DIR__ . '/vendor/autoload.php';

$container = new Container();

$container->set('config.app', static fn (): array => require __DIR__ . '/config/app.php');
$container->set('config.database', static fn (): array => require __DIR__ . '/config/database.php');
$container->set(Database::class, static fn (Container $container): Database => new Database($container->get('config.database')));
$container->set(Request::class, static fn (): Request => Request::capture());
$container->set(Response::class, static fn (): Response => new Response());
$container->set(Router::class, static fn (Container $container): Router => new Router($container));
$container->set(InstructorRepository::class, static fn (Container $container): InstructorRepository => new InstructorRepository($container->get(Database::class)));
$container->set(VehicleRepository::class, static fn (Container $container): VehicleRepository => new VehicleRepository($container->get(Database::class)));
$container->set(VehicleService::class, static fn (Container $container): VehicleService => new VehicleService($container->get(VehicleRepository::class)));

return $container;
