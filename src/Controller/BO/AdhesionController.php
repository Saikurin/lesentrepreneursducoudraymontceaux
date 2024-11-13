<?php

namespace App\Controller\BO;

use App\Enum\EtatDemandeAdhesion;
use App\Repository\DemandeAdhesionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/dashboard/adhesion')]
class AdhesionController extends AbstractController
{
    #[Route('/', name: 'dashboard.demande_adhesion', methods: ['GET'])]
    public function index(DemandeAdhesionRepository $demandeAdhesionRepository): Response
    {
        return $this->render('dashboard/adhesion/demande_adhesion.html.twig', [
            'demandes' => $demandeAdhesionRepository->findPending(),
        ]);
    }
    #[Route('/autoriser_adherant', name: 'dashboard_autoriser_adherant', methods: ['POST', 'GET'])]
    public function autoriser_adhesion(
        EntityManagerInterface $manager,
        Request $request,
        DemandeAdhesionRepository $demandeAdhesionRepository
    ): Response
    {
        // Décoder les données JSON envoyées par la requête POST
        $id = $request->request->get('id');
        if (!isset($id)) {
            return new Response("ID manquant", 400); // Gérer l'absence d'ID
        }

        // Récupérer la demande d'adhésion
        $demande = $demandeAdhesionRepository->find($id);
        if (!$demande) {
            return new Response("Demande introuvable", 404); // Si la demande n'existe pas
        }

        // Mettre à jour l'état de la demande
        $demande->setEtat(EtatDemandeAdhesion::VALIDE);
        $manager->flush();

        // Retourner uniquement le fragment du tableau à mettre à jour
        return $this->render('dashboard/adhesion/_partial_table.html.twig', [
            'demandes' => $demandeAdhesionRepository->findPending(),
        ]);
    }


}
