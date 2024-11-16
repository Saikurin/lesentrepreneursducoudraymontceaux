<?php

namespace App\Exception;

use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class AccountStatusException extends CustomUserMessageAuthenticationException
{

    public function __construct(string $message = 'Merci de bien vouloir réinitialiser votre mot de passe', array $messageData = [], int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $messageData, $code, $previous);
    }

    /**
     * Retourne le message d'erreur pour les développeurs.
     * Utile si vous souhaitez journaliser un message plus technique.
     */
    public function getTechnicalMessage(): string
    {
        return 'Le statut du compte utilisateur est invalide (désactivé, bloqué, etc.).';
    }

}