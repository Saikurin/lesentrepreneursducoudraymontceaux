<?php

namespace App\Controller\BO;

use App\Entity\User;
use App\Enum\EtatDemandeAdhesion;
use App\Repository\DemandeAdhesionRepository;
use App\Service\PasswordService;
use Doctrine\ORM\EntityManagerInterface;
use Random\RandomException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\PasswordHasherFactoryInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\PasswordHasher\PasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

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

    /**
     * @throws TransportExceptionInterface
     * @throws RandomException
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route('/gestion_adherant', name: 'dashboard_gestion_adherant', methods: ['POST', 'GET'])]
    public function gestion_adherant(
        EntityManagerInterface $manager,
        Request $request,
        DemandeAdhesionRepository $demandeAdhesionRepository,
        UserPasswordHasherInterface $hasher,
        PasswordService $passwordService

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

        switch ($request->request->get('type')) {
            case 'refuse':
                $demande->setEtat(EtatDemandeAdhesion::REFUSE);
                break;
            case 'accept':
                $demande->setEtat(EtatDemandeAdhesion::VALIDE);

                $password = $passwordService->generatePassword();

                $user = new User();

                $user->setEmail($demande->getContact());
                $user->setRoles(['ROLE_USER']);
                $user->setPassword($hasher->hashPassword($user, $password));

                $manager->persist($user);
                break;
        }
        // Mettre à jour l'état de la demande
        $manager->flush();

        // Retourner uniquement le fragment du tableau à mettre à jour
        return $this->render('dashboard/adhesion/_partial_table.html.twig', [
            'demandes' => $demandeAdhesionRepository->findPending(),
        ]);
    }


}
