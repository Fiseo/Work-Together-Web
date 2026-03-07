<?php

namespace App\Enum;

enum BookingStatus: string
{
    case Active = 'active';
    case NeedPayement = 'en attente de paiement';
    case Finished = 'terminée';
    case Null = 'aucun';

}
