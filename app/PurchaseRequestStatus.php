<?php

namespace App;

enum PurchaseRequestStatus: string
{
    case BORRADOR = 'borrador';
    case EN_REVISION = 'en_revision';
    case NUMERADA = 'numerada';
    case APROBADA = 'aprobada';
    case RECHAZADA = 'rechazada';
}