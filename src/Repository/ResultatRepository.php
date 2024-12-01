<?php
namespace App\Repository;

use Doctrine\DBAL\Connection;

class ResultatRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function getResultByEtu(string $etu, int $semestre): array
    {
        $sql = "
            SELECT 
                r.*, 
                m.libelle AS matiere_libelle, 
                m.credits AS matiere_credits, 
                s.libelle AS semestre_libelle
            FROM resultat r
            INNER JOIN matieres m ON r.idmatiere = m.idmatiere
            INNER JOIN semestre s ON m.idsemestre = s.idsemestre
            WHERE r.etu = :etu AND s.idsemestre = :semestre
        ";

        return $this->connection->fetchAllAssociative($sql, [
            'etu' => $etu,
            'semestre' => $semestre,
        ]);
    }
}
