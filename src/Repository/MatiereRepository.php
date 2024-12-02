<?php

namespace App\Repository;

use Doctrine\DBAL\Connection;

class MatiereRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Récupère toutes les matières par ID.
     *
     * @param int $id
     * @return array
     */
    public function getMatieresById(int $id): array
    {
        $sql = "
            SELECT * FROM matieres WHERE idmatiere = :id
        ";

        return $this->connection->fetchAllAssociative($sql, ['id' => $id]);
    }

    /**
     * Récupère toutes les matières pour un semestre donné.
     *
     * @param int $idSemestre
     * @return array
     */
    public function getMatieresBySemestreId(int $idSemestre): array
    {
        $sql = "
            SELECT * FROM matieres WHERE idsemestre = :idSemestre
        ";

        return $this->connection->fetchAllAssociative($sql, ['idSemestre' => $idSemestre]);
    }
}
