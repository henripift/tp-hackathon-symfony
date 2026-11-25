<?php

namespace App\Controller;
use App\Entity\Hackathon;
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
        $hackathons = $hackathonRepository->findAll();

        // render() génère le HTML à partir du template Twig
        return $this->render('hackathon/index.html.twig', [
            'hackathons' => $hackathons,
        ]);
    }

    // Version 2 : liste des hackathons au format JSON
    #[Route('/hackathons/api', name: 'app_hackathon_json', methods: ['GET'])]
    public function indexJson(HackathonRepository $hackathonRepository): JsonResponse
    {
        $hackathons = $hackathonRepository->findAll();

        // json() transforme les objets en JSON et renvoie une JsonResponse
        return $this->json($hackathons, 200, [], ['groups' => ['hackathon:read']]);
    }

    #[Route('/hackathons/api/{id}', name: 'app_hackathon_show_json', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function showJson(?Hackathon $hackathon = null): JsonResponse
    {
        if (!$hackathon) {
            return $this->json(
                ['error' => 'Hackathon introuvable'],
                404
            );
        }

        return $this->json($hackathon, 200, [], ['groups' => ['hackathon:read']]);
    }

    #[Route('/hackathon/{id}', name: 'app_hackathon_show', requirements: ['id' => '\d+'])]
    public function show(int $id, HackathonRepository $repo): Response
    {
        $hackathon = $repo->findWithInscriptions($id);

        if (!$hackathon) {
            throw $this->createNotFoundException('Hackathon introuvable');
        }

        return $this->render('hackathon/show.html.twig', ['hackathon' => $hackathon]);
    }


}
