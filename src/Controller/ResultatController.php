<?php
namespace App\Controller;

use App\Repository\ResultatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ResultatController extends AbstractController
{
    #[Route("/resultat/{etu}/{semester}", name: "note_etu", methods: ["GET"])]
    public function getResultats(string $etu, int $semester, ResultatRepository $resultatRepository): JsonResponse
    {
        try {
            // Récupérer les résultats de l'étudiant pour le semestre
            $resultats = $resultatRepository->getResultByEtu($etu, $semester);

            // Vérifier si des résultats ont été trouvés
            if (empty($resultats)) {
                return $this->json(
                    ['message' => 'Aucun résultat trouvé pour cet étudiant et ce semestre.'],
                    JsonResponse::HTTP_NOT_FOUND
                );
            }

            // Calculer la moyenne pondérée de l'étudiant
            $moyenne = $resultatRepository->calculerMoyenne($etu, $semester);

            // Ajouter la moyenne dans la réponse
            $responseData = [
                'resultats' => $resultats,
                'moyenne' => $moyenne
            ];

            return $this->json($responseData, JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            // Gérer les erreurs
            return $this->json(
                ['error' => 'Une erreur est survenue lors de la récupération des informations de l’étudiant.'],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
