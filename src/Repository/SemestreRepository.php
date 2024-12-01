<?php

namespace App\Repository;

use Doctrine\DBAL\Connection;

class SemestreRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Récupère tous les semestres.
     *
     * @return array
     */
    public function getAllSemestres(): array
    {
        $sql = "
            SELECT * from semestre
        ";

        return $this->connection->fetchAllAssociative($sql);
    }

    /**
     * Récupère un semestre par son ID.
     *
     * @param int $id
     * @return array
     */
    public function getSemestrebyId(int $id): array
    {
        $sql = "
            SELECT * from semestre WHERE id = :id
        ";

        return $this->connection->fetchAssociative($sql, ['id' => $id]);
    }
}
