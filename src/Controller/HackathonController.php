<?php

namespace App\Controller;

use App\Repository\HackathonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HackathonController extends AbstractController
{
    // Version 1 : liste des hackathons au format HTML
    #[Route('/hackathons', name: 'app_hackathon_index', methods: ['GET'])]
    public function index(HackathonRepository $hackathonRepository): Response
    {
        // Récupération de tous les enregistrements de la table hackathon
        $hackathons = $hackathonRepository->findAll();

        // Construction du HTML de la réponse
        $html = '<h1>Liste des hackathons</h1><ul>';
        foreach ($hackathons as $hackathon) {
            $html .= '<li>'
                . $hackathon->getId() . ' - '
                . $hackathon->getDateHeureDebut()->format('d/m/Y H:i') . ' au '
                . $hackathon->getDateHeureFin()->format('d/m/Y H:i') . ' - '
                . htmlspecialchars($hackathon->getLieu()) . ', '
                . htmlspecialchars($hackathon->getVille()) . ' - '
                . htmlspecialchars($hackathon->getTheme())
                . '</li>';
        }
        $html .= '</ul>';

        // Le serveur renvoie la réponse HTTP au client
        return new Response($html);
    }

    // Version 2 : liste des hackathons au format JSON
    #[Route('/hackathons/json', name: 'app_hackathon_json', methods: ['GET'])]
    public function indexJson(HackathonRepository $hackathonRepository): JsonResponse
    {
        $hackathons = $hackathonRepository->findAll();

        // json() transforme les objets en JSON et renvoie une JsonResponse
        return $this->json($hackathons);
    }
}
