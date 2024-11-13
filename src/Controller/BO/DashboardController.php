<?php

namespace App\Controller\BO;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

#[Route('/dashboard')]
class DashboardController extends AbstractController
{

    #[Route('/login', name: 'dashboard.login', methods: ['GET'])]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $username = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $username]);
    }

    #[Route('/', name: 'dashboard.index', methods: ['GET'])]
    public function dashboard(): Response
    {
        return $this->render('dashboard/dashboard.html.twig');
    }

    public function getNavbar(EntityManagerInterface $manager): Response
    {
        $counter = $manager->getConnection()->executeQuery("select count(id) as nb_demande_adhesion
from demande_adhesion
where etat = 'En attente'")->fetchAssociative();
        return $this->render('dashboard/navbar.html.twig', [
            'counter' => $counter,
        ]);
    }
}