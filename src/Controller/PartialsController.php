<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PartialsController extends AbstractController
{
    public function getNavbar(EntityManagerInterface $manager): Response
    {
        $counter = $manager->getConnection()->executeQuery("select count(id) as nb_demande_adhesion
from demande_adhesion
where etat = 'En attente'")->fetchAssociative();
        return $this->render('dashboard/navbar.html.twig', [
            'counter' => $counter,
        ]);
    }

    public function getEvents(EventRepository $eventRepository): Response
    {
        return $this->render('partials/events_footer.html.twig', [
            'events' => $eventRepository->getFuturesEvents()
        ]);
    }
}
