<?php

namespace App\Enums;

use App\Traits\DbEnumTrait;

enum SocialCategoryEnum:string
{
    use DbEnumTrait;
    
    case GENERAL = 'General';
    case SC = 'Scheduled Caste';
    case ST = 'Scheduled Tribe';
    case OBC = 'Other Backward Class';
}