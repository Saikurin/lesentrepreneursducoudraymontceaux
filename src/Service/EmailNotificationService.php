<?php

namespace App\Service;

use App\Entity\DemandeAdhesion;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class EmailNotificationService
{


    private $mailer;
    private $twig;

    public function __construct(MailerInterface $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function sendAdminNotification(string $adminEmail, DemandeAdhesion $demande): void
    {
        $email = (new Email())
            ->from('no_reply@lesentrepreneursudcoudraymontceaux.fr')
            ->to($adminEmail)
            ->subject('Nouvelle demande d\'adhésion')
            ->html($this->twig->render('emails/admin_notification.html.twig', [
                'demande' => $demande,
            ]));

        $this->mailer->send($email);
    }

    public function sendUserConfirmation(string $userEmail, DemandeAdhesion $demande, string $trackingLink): void
    {
        $email = (new Email())
            ->from('no_reply@lesentrepreneursudcoudraymontceaux.fr')
            ->to($userEmail)
            ->subject('Confirmation de votre demande d\'adhésion')
            ->html($this->twig->render('emails/user_confirmation.html.twig', [
                'demande' => $demande,
                'trackingLink' => $trackingLink,
            ]));

        $this->mailer->send($email);
    }

    public function sendDevNotificationError(\Exception $e)
    {

        $email = (new Email())
            ->from('no_reply@lesentrepreneursudcoudraymontceaux.fr')
            ->to('siklitheo@gmail.com')
            ->subject('Erreur LEDCM')
            ->html($this->twig->render('emails/dev_notification.html.twig', [
                'error' => $e,
            ]));

        $this->mailer->send($email);
    }

}