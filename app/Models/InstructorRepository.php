<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Database;
use PDO;

final class InstructorRepository
{
    public function __construct(
        private readonly Database $database
    ) {
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function paginate(int $page, int $perPage): array
    {
        $offset = ($page - 1) * $perPage;
        $statement = $this->pdo()->prepare(
            'SELECT Id, Voornaam, Tussenvoegsel, Achternaam, Mobiel, DatumInDienst, AantalSterren
             FROM Instructeur
             WHERE IsActief = 1
             ORDER BY CHAR_LENGTH(AantalSterren) DESC, Achternaam ASC
             LIMIT :limit OFFSET :offset'
        );
        $statement->bindValue(':limit', $perPage, PDO::PARAM_INT);
        $statement->bindValue(':offset', $offset, PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function countActive(): int
    {
        return (int) $this->pdo()
            ->query('SELECT COUNT(*) FROM Instructeur WHERE IsActief = 1')
            ->fetchColumn();
    }

    /**
     * @return array<string, mixed>|null
     */
    public function findById(int $id): ?array
    {
        $statement = $this->pdo()->prepare(
            'SELECT Id, Voornaam, Tussenvoegsel, Achternaam, Mobiel, DatumInDienst, AantalSterren
             FROM Instructeur
             WHERE Id = :id AND IsActief = 1'
        );
        $statement->execute(['id' => $id]);
        $result = $statement->fetch();

        return $result ?: null;
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    public function allActive(): array
    {
        return $this->pdo()
            ->query(
                'SELECT Id, Voornaam, Tussenvoegsel, Achternaam, Mobiel, DatumInDienst, AantalSterren
                 FROM Instructeur
                 WHERE IsActief = 1
                 ORDER BY CHAR_LENGTH(AantalSterren) DESC, Achternaam ASC'
            )
            ->fetchAll();
    }

    private function pdo(): PDO
    {
        return $this->database->connection();
    }
}
