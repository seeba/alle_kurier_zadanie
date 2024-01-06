<?php

namespace App\Core\User\Domain\Status;

enum UserStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}
