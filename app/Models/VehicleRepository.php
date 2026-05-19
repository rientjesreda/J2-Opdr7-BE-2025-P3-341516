<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

class VehicleRepository
{
    public function __construct(
        private readonly Database $database
    ) {
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function paginateAssignedToInstructor(int $instructorId, int $page, int $perPage): array
    {
        $offset = ($page - 1) * $perPage;
        $statement = $this->pdo()->prepare(
            'SELECT v.Id, v.Kenteken, v.Type, v.Bouwjaar, v.Brandstof, tv.TypeVoertuig, tv.Rijbewijscategorie,
                    vi.InstructeurId, vi.DatumToekenning
             FROM Voertuig v
             INNER JOIN TypeVoertuig tv ON tv.Id = v.TypeVoertuigId
             INNER JOIN VoertuigInstructeur vi ON vi.VoertuigId = v.Id AND vi.IsActief = 1
             WHERE vi.InstructeurId = :instructorId
               AND v.IsActief = 1
               AND tv.IsActief = 1
             ORDER BY tv.Rijbewijscategorie ASC, v.Type ASC
             LIMIT :limit OFFSET :offset'
        );
        $statement->bindValue(':instructorId', $instructorId, PDO::PARAM_INT);
        $statement->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function countAssignedToInstructor(int $instructorId): int
    {
        $statement = $this->pdo()->prepare(
            'SELECT COUNT(*)
             FROM VoertuigInstructeur
             WHERE InstructeurId = :instructorId
               AND IsActief = 1'
        );
        $statement->execute(['instructorId' => $instructorId]);

        return (int) $statement->fetchColumn();
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function paginateAvailable(int $page, int $perPage): array
    {
        $offset = ($page - 1) * $perPage;
        $statement = $this->pdo()->prepare(
            'SELECT v.Id, v.Kenteken, v.Type, v.Bouwjaar, v.Brandstof, tv.TypeVoertuig, tv.Rijbewijscategorie
             FROM Voertuig v
             INNER JOIN TypeVoertuig tv ON tv.Id = v.TypeVoertuigId
             LEFT JOIN VoertuigInstructeur vi ON vi.VoertuigId = v.Id AND vi.IsActief = 1
             WHERE vi.Id IS NULL
               AND v.IsActief = 1
               AND tv.IsActief = 1
             ORDER BY tv.Rijbewijscategorie ASC, v.Type ASC
             LIMIT :limit OFFSET :offset'
        );
        $statement->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function countAvailable(): int
    {
        return (int) $this->pdo()
            ->query(
                'SELECT COUNT(*)
                 FROM Voertuig v
                 LEFT JOIN VoertuigInstructeur vi ON vi.VoertuigId = v.Id AND vi.IsActief = 1
                 WHERE vi.Id IS NULL
                   AND v.IsActief = 1'
            )
            ->fetchColumn();
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findVehicleForEdit(int $vehicleId): ?array
    {
        $statement = $this->pdo()->prepare(
            'SELECT v.Id, v.Kenteken, v.Type, v.Bouwjaar, v.Brandstof, v.TypeVoertuigId, tv.TypeVoertuig, tv.Rijbewijscategorie,
                    vi.InstructeurId
             FROM Voertuig v
             INNER JOIN TypeVoertuig tv ON tv.Id = v.TypeVoertuigId
             LEFT JOIN VoertuigInstructeur vi ON vi.VoertuigId = v.Id AND vi.IsActief = 1
             WHERE v.Id = :vehicleId AND v.IsActief = 1'
        );
        $statement->execute(['vehicleId' => $vehicleId]);
        $result = $statement->fetch();

        return $result ?: null;
    }

    public function updateVehicleAndAssignment(
        int $vehicleId,
        string $kenteken,
        string $type,
        string $brandstof,
        int $targetInstructorId,
        ?string $opmerking = null
    ): void {
        $statement = $this->pdo()->prepare('CALL spUpdateVehicleAndAssignment(:vehicleId, :kenteken, :type, :brandstof, :instructorId, :opmerking)');
        $statement->execute([
            'vehicleId' => $vehicleId,
            'kenteken' => $kenteken,
            'type' => $type,
            'brandstof' => $brandstof,
            'instructorId' => $targetInstructorId,
            'opmerking' => $opmerking,
        ]);

        while ($statement->nextRowset()) {
        }
    }

    /**
     * @return array<int, string>
     */
    public function availableFuelTypes(): array
    {
        return ['Benzine', 'Diesel', 'Elektrisch', 'Hybride'];
    }

    private function pdo(): PDO
    {
        return $this->database->connection();
    }
}
