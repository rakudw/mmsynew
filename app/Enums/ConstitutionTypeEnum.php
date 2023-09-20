<?php

namespace App\Enums;

use App\Traits\DbEnumTrait;

enum ConstitutionTypeEnum:string
{
    use DbEnumTrait;

    case PROPRIETORSHIP = 'Proprietorship';
    case PARTNERSHIP = 'Partnership';
    case LIMITED_LIABILITY_PARTNERSHIP = 'Limited Liability Partnership(LLP)';
    case PRIVATE_LIMITED = 'Private Limited';
    case COOPERATIVE_SOCIETY = 'Cooperative Society';
    case SELF_HELP_GROUP = 'Self-Help Group';
}