<?php

namespace App\Enums;

use App\Traits\DbEnumTrait;

enum RegionTypeEnum:string
{
    use DbEnumTrait;
    
    case COUNTRY = 'Country';
    case STATE = 'State';
    case UNION_TERRITORY = 'Union Territory';
    case DISTRICT = 'District';
    case CONSTITUENCY = 'Constituency';
    case TEHSIL = 'Tehsil';
    case BLOCK_TOWN = 'Block/Town';
    case PANCHAYAT_WARD = 'Panchayat/Ward';
    case VILLAGE = 'Village';
}