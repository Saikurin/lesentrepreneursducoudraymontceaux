<?php

namespace App\Enum;

enum EtatDemandeAdhesion: string
{

    case EN_ATTENTE = 'En attente';
    case EN_COURS = 'En cours';

    case VALIDE = 'Validé';

    case REFUSE = 'Refusé';

}
