<?php
namespace App\Controller;

use App\Repository\ResultatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ResultatController extends AbstractController
{
    #[Route("/resultat/{etu}/{semester}", name: "note_etu", methods: ["GET"])]
    public function getResultats(string $etu,int $semester ,ResultatRepository $resultatRepository): JsonResponse
    {
        $resultats = $resultatRepository->getResultByEtu($etu, $semester);
        return $this->json($resultats);
    }
}
