<?php

namespace App\Core\User\Domain\Repository;

use App\Core\User\Domain\Exception\UserNotFoundException;
use App\Core\User\Domain\Status\UserStatus;
use App\Core\User\Domain\User;

interface UserRepositoryInterface
{
    /**
     * @return User[]
     */
    public function getUsersByStatus(UserStatus $status): array;
    
    /**
     * @throws UserNotFoundException
     */
    public function getByEmail(string $email): User;

    public function save(User $user): void;

    public function flush(): void;
}
