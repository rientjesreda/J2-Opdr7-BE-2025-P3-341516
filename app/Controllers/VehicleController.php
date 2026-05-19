<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Response;
use App\Models\InstructorRepository;
use App\Models\VehicleRepository;
use App\Services\VehicleService;
use InvalidArgumentException;
use RuntimeException;

final class VehicleController extends Controller
{
    /**
     * @param array<string, mixed> $config
     */
    public function __construct(
        private readonly InstructorRepository $instructorRepository,
        private readonly VehicleRepository $vehicleRepository,
        private readonly VehicleService $vehicleService,
        private readonly Response $response,
        private readonly array $config
    ) {
    }

    public function assigned(Request $request): void
    {
        $instructorId = (int) $request->query('instructor_id', 0);
        $instructor = $this->requireInstructor($instructorId);
        $page = max(1, (int) $request->query('page', 1));
        $perPage = 4;

        $this->render($this->response, 'vehicles/assigned', [
            'view' => 'vehicles/assigned',
            'title' => 'Door instructeur gebruikte voertuigen',
            'instructor' => $instructor,
            'vehicles' => $this->vehicleRepository->paginateAssignedToInstructor($instructorId, $page, $perPage),
            'page' => $page,
            'perPage' => $perPage,
            'total' => $this->vehicleRepository->countAssignedToInstructor($instructorId),
            'flash' => (string) $request->query('message', ''),
        ]);
    }

    public function available(Request $request): void
    {
        $instructorId = (int) $request->query('instructor_id', 0);
        $instructor = $this->requireInstructor($instructorId);
        $page = max(1, (int) $request->query('page', 1));
        $perPage = 4;

        $this->render($this->response, 'vehicles/available', [
            'view' => 'vehicles/available',
            'title' => 'Alle beschikbare voertuigen',
            'instructor' => $instructor,
            'vehicles' => $this->vehicleRepository->paginateAvailable($page, $perPage),
            'page' => $page,
            'perPage' => $perPage,
            'total' => $this->vehicleRepository->countAvailable(),
            'flash' => (string) $request->query('message', ''),
        ]);
    }

    public function edit(Request $request): void
    {
        $vehicleId = (int) $request->query('id', 0);
        $currentInstructorId = (int) $request->query('instructor_id', 0);
        $origin = (string) $request->query('origin', 'assigned');
        $vehicle = $this->requireVehicle($vehicleId);
        $instructor = $this->requireInstructor($currentInstructorId);

        $this->render($this->response, 'vehicles/edit', [
            'view' => 'vehicles/edit',
            'title' => 'Wijzigen voertuiggegevens',
            'instructor' => $instructor,
            'vehicle' => $vehicle,
            'allInstructors' => $this->instructorRepository->allActive(),
            'fuelTypes' => $this->vehicleRepository->availableFuelTypes(),
            'origin' => $origin,
            'error' => (string) $request->query('error', ''),
        ]);
    }

    public function update(Request $request): void
    {
        $vehicleId = (int) $request->input('vehicle_id', 0);
        $currentInstructorId = (int) $request->input('current_instructor_id', 0);
        $origin = (string) $request->input('origin', 'assigned');
        $vehicle = $this->requireVehicle($vehicleId);

        try {
            $validated = $this->vehicleService->validateAndSanitize($request->all());
            $this->vehicleService->ensureReadonlyBuildYearUnchanged(
                (string) $request->input('bouwjaar', ''),
                (string) $vehicle['Bouwjaar']
            );

            $this->vehicleRepository->updateVehicleAndAssignment(
                $vehicleId,
                $validated['kenteken'],
                $validated['type'],
                $validated['brandstof'],
                $validated['instructeur_id'],
                $validated['opmerking']
            );
        } catch (InvalidArgumentException $exception) {
            $query = http_build_query([
                'id' => $vehicleId,
                'instructor_id' => $currentInstructorId,
                'origin' => $origin,
                'error' => $exception->getMessage(),
            ]);
            $this->response->redirect('/vehicles/edit?' . $query);
        }

        $message = $origin === 'available'
            ? 'Voertuig is bijgewerkt en toegewezen aan de instructeur.'
            : 'Voertuiggegevens zijn succesvol gewijzigd.';

        $this->response->redirect('/vehicles?instructor_id=' . $currentInstructorId . '&message=' . urlencode($message));
    }

    /**
     * @return array<string, mixed>
     */
    private function requireInstructor(int $id): array
    {
        $instructor = $this->instructorRepository->findById($id);

        if ($instructor === null) {
            throw new RuntimeException('Instructeur niet gevonden.');
        }

        return $instructor;
    }

    /**
     * @return array<string, mixed>
     */
    private function requireVehicle(int $id): array
    {
        $vehicle = $this->vehicleRepository->findVehicleForEdit($id);

        if ($vehicle === null) {
            throw new RuntimeException('Voertuig niet gevonden.');
        }

        return $vehicle;
    }
}
