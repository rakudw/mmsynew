<?php

namespace App\Enums;

use App\Traits\DbEnumTrait;

enum ActivityTypeEnum:string
{
    use DbEnumTrait;

    case MANUFACTURING = 'Manufacturing';
    case SERVICING = 'Servicing';
    case TRADING = 'Trading';
}