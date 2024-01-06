<?php

namespace App\Core\User\Infrastructure\Persistance;

use App\Core\User\Domain\Exception\InactiveUsersNotFoundException;
use App\Core\User\Domain\Exception\UserNotFoundException;
use App\Core\User\Domain\Repository\UserRepositoryInterface;
use App\Core\User\Domain\Status\UserStatus;
use App\Core\User\Domain\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Psr\EventDispatcher\EventDispatcherInterface;

class DoctrineUserRepository implements UserRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager, 
        private readonly EventDispatcherInterface $eventDispatcher
    ) {}

    /**
     * @throws NonUniqueResultException
     */
    public function getByEmail(string $email): User
    {
        $user = $this->entityManager->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.email = :user_email')
            ->setParameter(':user_email', $email)
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        if (null === $user) {
            throw new UserNotFoundException('Użytkownik nie istnieje');
        }

        return $user;
    }

    public function getUsersByStatus(UserStatus $status): array
    {
        $users = $this->entityManager->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.active = :active')
            ->setParameter('active', $status)
            ->getQuery()
            ->getResult();

        if (null === $users) {
            throw new InactiveUsersNotFoundException('Nie znaleziono użytkowników o statusie :'.$status);
        }

        return $users;
    }

    public function save(User $user): void
    {
        $this->entityManager->persist($user);

        $events = $user->pullEvents();
        foreach ($events as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }

    public function flush(): void
    {
        $this->entityManager->flush();
    }
}
