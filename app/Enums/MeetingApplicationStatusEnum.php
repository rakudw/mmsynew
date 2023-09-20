<?php

namespace App\Enums;

use App\Traits\DbEnumTrait;

enum MeetingApplicationStatusEnum:string
{
    use DbEnumTrait;

    case PENDING = 'PENDING';
    case APPROVED = 'APPROVED';
    case REJECTED = 'REJECTED';
    case DEFERRED = 'DEFERRED';
}