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

    /**
     * Récupère les résultats d'un étudiant pour un semestre donné.
     *
     * @param string $etu
     * @param int $semestre
     * @return array
     */
    public function getResultByEtu(string $etu, int $semestre): array
    {
        $sql = "
            SELECT 
                r.*, 
                m.code AS matiere_code,
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

    /**
     * Calcule la moyenne pondérée des résultats pour un étudiant et un semestre donné.
     *
     * @param string $etu
     * @param int $semestre
     * @return float
     */
    public function calculerMoyenne(string $etu, int $semestre): float
    {
        // Récupérer les résultats de l'étudiant pour le semestre
        $resultats = $this->getResultByEtu($etu, $semestre);

        $totalNotesPonderees = 0;
        $totalCredits = 0;

        // Calculer la somme des notes pondérées et des crédits
        foreach ($resultats as $resultat) {
            if (isset($resultat['notes']) && is_numeric($resultat['notes'])) {
                $note = floatval($resultat['notes']);
                $credits = floatval($resultat['matiere_credits']);

                $totalNotesPonderees += $note * $credits;
                $totalCredits += $credits;
            }
        }

        // Retourner la moyenne pondérée, ou 0 si les crédits sont 0
        if ($totalCredits > 0) {
            return $totalNotesPonderees / $totalCredits;
        }

        return 0.0;
    }
}
