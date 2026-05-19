<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\VehicleRepository;
use InvalidArgumentException;

final class VehicleService
{
    public function __construct(
        private readonly VehicleRepository $vehicleRepository
    ) {
    }

    /**
     * @param array<string, mixed> $input
     * @return array{kenteken: string, type: string, brandstof: string, instructeur_id: int, opmerking: string}
     */
    public function validateAndSanitize(array $input, bool $assignmentRequired = true): array
    {
        $kenteken = strtoupper(trim((string) ($input['kenteken'] ?? '')));
        $type = trim((string) ($input['type'] ?? ''));
        $brandstof = trim((string) ($input['brandstof'] ?? ''));
        $instructeurId = (int) ($input['instructeur_id'] ?? 0);
        $opmerking = trim((string) ($input['opmerking'] ?? ''));

        if ($kenteken === '' || ! preg_match('/^[A-Z0-9-]{5,10}$/', $kenteken)) {
            throw new InvalidArgumentException('Voer een geldig kenteken in.');
        }

        if ($type === '' || mb_strlen($type) > 50) {
            throw new InvalidArgumentException('Voer een geldig voertuigtype in van maximaal 50 tekens.');
        }

        if (! in_array($brandstof, $this->vehicleRepository->availableFuelTypes(), true)) {
            throw new InvalidArgumentException('Kies een geldige brandstofsoort.');
        }

        if ($assignmentRequired && $instructeurId < 1) {
            throw new InvalidArgumentException('Kies een instructeur.');
        }

        if (mb_strlen($opmerking) > 250) {
            throw new InvalidArgumentException('De opmerking mag maximaal 250 tekens bevatten.');
        }

        return [
            'kenteken' => $kenteken,
            'type' => $type,
            'brandstof' => $brandstof,
            'instructeur_id' => $instructeurId,
            'opmerking' => $opmerking,
        ];
    }

    public function ensureReadonlyBuildYearUnchanged(string $submitted, string $stored): void
    {
        if ($submitted !== $stored) {
            throw new InvalidArgumentException('Bouwjaar mag niet worden gewijzigd.');
        }
    }
}
