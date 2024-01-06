<?php

namespace App\Core\User\Application\Query\GetUsersEmailsByStatus;

use App\Core\User\Domain\Status\UserStatus;

class GetUsersEmailsByStatusQuery
{
    public function __construct(public readonly UserStatus $status)
    {
    }
}
