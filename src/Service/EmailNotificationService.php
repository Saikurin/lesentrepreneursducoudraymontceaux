<?php

namespace App\Service;

use App\Entity\DemandeAdhesion;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class EmailNotificationService
{


    private $mailer;
    private $twig;

    public function __construct(MailerInterface $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    /**
     * @throws SyntaxError
     * @throws RuntimeError
     * @throws LoaderError
     */
    public function sendAdminNotification(string $adminEmail, DemandeAdhesion $demande): void
    {
        $email = (new Email())
            ->from('no-reply@lesentrepreneursducoudraymontceaux.fr')
            ->to($adminEmail)
            ->subject('Nouvelle demande d\'adhésion')
            ->html($this->twig->render('emails/admin_notification.html.twig', [
                'demande' => $demande,
            ]));

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            throw new \Exception('Erreur lors de l\'envoi de l\'email');
        }
    }

    public function sendUserConfirmation(string $userEmail, DemandeAdhesion $demande, string $trackingLink): void
    {
        $email = (new Email())
            ->from('no-reply@lesentrepreneursducoudraymontceaux.fr')
            ->to($userEmail)
            ->subject('Confirmation de votre demande d\'adhésion')
            ->html($this->twig->render('emails/user_confirmation.html.twig', [
                'demande' => $demande,
                'trackingLink' => $trackingLink,
            ]));

        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            var_dump($e);
        }
    }

    public function sendDevNotificationError(\Exception $e)
    {

        $email = (new Email())
            ->from('no-reply@lesentrepreneursducoudraymontceaux.fr')
            ->to('siklitheodev@gmail.com')
            ->subject('Erreur LEDCM')
            ->html($this->twig->render('emails/dev_notification.html.twig', [
                'error' => $e,
            ]));

        $this->mailer->send($email);
    }

    public function sendUserMail(string $userEmail, string $subject, array $context): void
    {
        $email = (new Email())
            ->from('no-reply@lesentrepreneursducoudraymontceaux.fr')
            ->to($userEmail)
            ->subject($subject)
            ->html($this->twig->render('emails/user_mail.html.twig', $context));
        $this->mailer->send($email);
    }

}