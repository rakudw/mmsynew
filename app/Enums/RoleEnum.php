<?php

namespace App\Enums;

enum RoleEnum:int
{
    case USER = 0;
    case SUPER_ADMIN = 1;
    case NODAL_DIC = 2;
    case GM_DIC = 3;
    CASE EO_DIC = 4;
    case BANK_MANAGER = 5;
    case NODAL_BANK = 6;
    case BANK_RO = 7;
    case UDYAMI_MITRA = 8;
}