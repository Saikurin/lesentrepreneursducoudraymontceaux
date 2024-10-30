<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SuiviAdhesionController extends AbstractController
{
    #[Route('/suivi_adhesion/{id}', name: 'app_suivi_adhesion')]
    public function index(): Response
    {
        return $this->render('suivi_adhesion/index.html.twig', [
            'controller_name' => 'SuiviAdhesionController',
        ]);
    }
}
