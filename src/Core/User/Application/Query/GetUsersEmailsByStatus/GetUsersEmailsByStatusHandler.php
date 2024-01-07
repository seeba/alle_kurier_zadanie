<?php

namespace App\Core\User\Application\Query\GetUsersEmailsByStatus;

use App\Core\User\Domain\User;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use App\Core\User\Application\DTO\EmailDTO;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class GetUsersEmailsByStatusHandler
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository
    ) {}

    public function __invoke(GetUsersEmailsByStatusQuery $query): array
    {
        $users = $this->userRepository->getUsersByStatus(
            $query->status
        );
        
        return array_map(function (User $user) {
            return new EmailDTO(
                $user->getEmail()
            );
        }, $users);
    }
}
