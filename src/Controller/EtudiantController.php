<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\StudentRepository;

class EtudiantController extends AbstractController
{
    private StudentRepository $studentRepository;

    // Injecter le StudentRepository dans le constructeur
    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    } 

    // test
    #[Route("/etudiants", name: "liste_etudiant", methods: ["GET"])]
    public function getAll(): JsonResponse
    {
        try {
            $etudiants = $this->studentRepository->getAllStudents();

            // Vérifier si des étudiants existent
            if (empty($etudiants)) {
                return $this->json(
                    ['message' => 'Aucun étudiant trouvé.'],
                    JsonResponse::HTTP_NO_CONTENT
                );
            }

            return $this->json($etudiants, JsonResponse::HTTP_OK);

        } catch (\Exception $e) {
            // Gérer les exceptions pour éviter de dévoiler des détails sensibles
            return $this->json(
                ['error' => 'Une erreur est survenue lors de la récupération des étudiants.'],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    #[Route("/etudiants/{etu}", name: "etudiant_par_etu", methods: ["GET"])]
    public function getByEtu(string $etu): JsonResponse
    {
        try {
            $etudiant = $this->studentRepository->getStudentByEtu($etu);

            if (!$etudiant) {
                return $this->json(
                    ['message' => 'Étudiant non trouvé.'],
                    JsonResponse::HTTP_NOT_FOUND
                );
            }

            return $this->json($etudiant, JsonResponse::HTTP_OK);

        } catch (\Exception $e) {
            return $this->json(
                ['error' => 'Une erreur est survenue lors de la récupération de l’étudiant.'],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    #[Route("/etudiants/{etu}/{semestre}", name: "etudiant_par_etu_semestre", methods: ["GET"])]
    public function getByEtuAndSemester(string $etu, int $semestre): JsonResponse
    {
        try {
            $etudiant = $this->studentRepository->getStudentWithSemesterAndOption($etu, $semestre);

            if (!$etudiant) {
                return $this->json(
                    ['message' => 'Aucune information trouvée pour cet étudiant et ce semestre.'],
                    JsonResponse::HTTP_NOT_FOUND
                );
            }

            return $this->json($etudiant, JsonResponse::HTTP_OK);

        } catch (\Exception $e) {
            return $this->json(
                ['error' => 'Une erreur est survenue lors de la récupération des informations de l’étudiant.'],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

 
}
