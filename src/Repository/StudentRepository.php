<?php

namespace App\Repository;

use Doctrine\DBAL\Connection;

class StudentRepository
{
    private Connection $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Récupère tous les étudiants.
     *
     * @return array
     */
    public function getAllStudents(): array
    {
        $sql = "
            SELECT 
                etu, 
                nom, 
                prenom, 
                naissance
            FROM etudiant
        ";

        return $this->connection->fetchAllAssociative($sql);
    }

    /**
     * Récupère les informations d'un étudiant par son ETU.
     *
     * @param string $etu
     * @return array|null
     */
    public function getStudentByEtu(string $etu): ?array
    {
        $sql = "
            SELECT 
                etu, 
                nom, 
                prenom, 
                naissance            
                FROM etudiant
            WHERE etu = :etu
        ";

        $result = $this->connection->fetchAssociative($sql, ['etu' => $etu]);

        return $result ?: null;
    }

        /**
     * Récupère les informations d'un étudiant avec ses matières pour un semestre donné.
     *
     * @param string $etu L'identifiant de l'étudiant.
     * @param int $semestre L'identifiant du semestre.
     * @return array|null Les informations de l'étudiant et son semestre, ou null si non trouvé.
     */
    public function getStudentWithSemesterAndOption(string $etu, int $semestre): ?array
    {
        $sql = "
            SELECT 
                e.ETU AS idEtudiant,
                e.nom AS nomEtudiant,
                e.prenom AS prenomEtudiant,
                e.naissance AS dateNaissance,
                MAX(s.libelle) AS semestre,
                MAX(o.designation) AS optionChoisie
            FROM 
                resultat r
            INNER JOIN 
                etudiant e ON e.ETU = r.ETU
            INNER JOIN 
                matieres m ON r.idMatiere = m.idMatiere
            INNER JOIN 
                semestre s ON s.idSemestre = m.idSemestre
            INNER JOIN 
                options o ON o.idOptions = m.idOptions
            WHERE 
                e.ETU = :etu
                AND s.idSemestre = :semestre
            GROUP BY 
                e.ETU, e.nom, e.prenom, e.naissance
        ";

        $result = $this->connection->fetchAssociative($sql, [
            'etu' => $etu,
            'semestre' => $semestre,
        ]);

        return $result ?: null;
    }

}
