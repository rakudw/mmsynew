<?php

namespace App\Enums;

use App\Traits\DbEnumTrait;

enum BankTypeEnum:string
{
    use DbEnumTrait;
    
    case PUBLIC_SECTOR_BANK = 'Public Sector Bank';
    case SMALL_FINANCE_BANK = 'Small Finance Bank';
    case URBAN_COOPERATIVE_SECTOR_BANK = 'Urban Co-operative Sector Bank';
    case COOPERATIVE_SECTOR_BANK = 'Co-operative Sector Bank';
    case REGIONAL_RURAL_BANK = 'Regional Rural Bank';
    case PRIVATE_SECTOR_BANK = 'Private Sector Bank';
}