<?php
namespace App\Controller;

use App\Repository\SemestreRepository; // Assurez-vous d'importer le repository correct
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class SemestreController extends AbstractController
{
    private SemestreRepository $semestreRepository;

    // Injection du repository SemestreRepository
    public function __construct(SemestreRepository $semestreRepository)
    {
        $this->semestreRepository = $semestreRepository;
    }

    #[Route("/semestres", name: "liste_semestres", methods: ["GET"])]
    public function getAllSemestres(): JsonResponse
    {
        try {
            $semestres = $this->semestreRepository->getAllSemestres(); // Appel à la méthode getAllSemestres

            if (empty($semestres)) {
                return $this->json(
                    ['message' => 'Aucun semestre trouvé.'],
                    JsonResponse::HTTP_NO_CONTENT
                );
            }

            return $this->json($semestres, JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return $this->json(
                ['error' => 'Une erreur est survenue lors de la récupération des semestres.'],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    // Nouvelle méthode pour récupérer un semestre par son ID
    #[Route("/semestres/{id}", name: "semestre_by_id", methods: ["GET"])]
    public function getSemestreById(int $id): JsonResponse
    {
        try {
            $semestre = $this->semestreRepository->getSemestrebyId($id); // Appel à la méthode getSemestrebyId

            if (!$semestre) {
                return $this->json(
                    ['message' => 'Semestre non trouvé.'],
                    JsonResponse::HTTP_NOT_FOUND
                );
            }

            return $this->json($semestre, JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return $this->json(
                ['error' => 'Une erreur est survenue lors de la récupération du semestre.'],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}

