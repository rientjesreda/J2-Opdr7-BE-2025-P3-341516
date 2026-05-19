<?php

declare(strict_types=1);

namespace Tests;

use App\Models\VehicleRepository;
use App\Services\VehicleService;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

final class VehicleServiceTest extends TestCase
{
    public function testValidateAndSanitizeReturnsCleanData(): void
    {
        $repository = $this->createMock(VehicleRepository::class);
        $repository->method('availableFuelTypes')->willReturn(['Benzine', 'Diesel', 'Elektrisch', 'Hybride']);

        $service = new VehicleService($repository);

        $result = $service->validateAndSanitize([
            'kenteken' => ' drs-52-e ',
            'type' => 'Vespa Piaggio',
            'brandstof' => 'Elektrisch',
            'instructeur_id' => '4',
            'opmerking' => '  scenario 1  ',
        ]);

        self::assertSame('DRS-52-E', $result['kenteken']);
        self::assertSame('Vespa Piaggio', $result['type']);
        self::assertSame('Elektrisch', $result['brandstof']);
        self::assertSame(4, $result['instructeur_id']);
        self::assertSame('scenario 1', $result['opmerking']);
    }

    public function testEnsureReadonlyBuildYearThrowsWhenChanged(): void
    {
        $repository = $this->createMock(VehicleRepository::class);
        $service = new VehicleService($repository);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Bouwjaar mag niet worden gewijzigd.');

        $service->ensureReadonlyBuildYearUnchanged('2020-01-01', '2019-05-23');
    }
}
