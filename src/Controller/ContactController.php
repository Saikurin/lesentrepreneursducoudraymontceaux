<?php

namespace App\Controller;

use App\Entity\DemandeAdhesion;
use App\Form\AdhesionType;
use App\Service\EmailNotificationService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_demande_adhesion', methods: ['POST', 'GET'])]
    public function index(Request $request, EntityManagerInterface $manager, EmailNotificationService $notificationService): Response
    {
        $demande = new DemandeAdhesion();
        $form = $this->createForm(AdhesionType::class, $demande);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($demande);
            $manager->flush();

            $trackingLink = $this->generateUrl('app_suivi_adhesion', ['id' => $demande->getId()], true);
            try {
            $notificationService->sendAdminNotification('contact@lesentrepreneursducoudraymontceaux.fr', $demande);
            $notificationService->sendUserConfirmation($demande->getContact(), $demande, $trackingLink);
            } catch (\Exception $e) {
                $this->addFlash('error', 'Une erreur est survenue (E. C_33');
                $notificationService->sendDevNotificationError($e);
            }

            $this->addFlash('success','Votre demande a été soumise au bureau. Nous reviendrons vers vous très vide. De plus, vous venez de recevoir un mail contenant un lien afin de suivre l\'avancée de votre demande');
            return $this->redirectToRoute('app_home_temp');
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
