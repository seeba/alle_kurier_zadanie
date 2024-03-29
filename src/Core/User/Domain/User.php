<?php

namespace App\Core\User\Domain;

use App\Common\EventManager\EventsCollectorTrait;
use App\Core\User\Domain\Event\UserCreatedEvent;
use App\Core\User\Domain\Status\UserStatus;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: "users")]
class User
{
    use EventsCollectorTrait;

   
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:'AUTO')]
    #[ORM\Column(type: "integer", options: ["unsigned" =>true], nullable: false)]
    private ?int $id;

    #[ORM\Column(type: "string", length: 300, nullable: false)]
    private string $email;

    #[ORM\Column(type: "string", enumType: "\App\Core\User\Domain\Status\UserStatus", nullable: false)]
    private UserStatus $status;

    public function __construct(string $email)
    {
        $this->id = null;
        $this->email = $email;
        $this->status = UserStatus::INACTIVE;

        $this->record(new UserCreatedEvent($this));
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getStatus(): UserStatus
    {
        return $this->status;
    }

    public function setStatus(UserStatus $status): void
    {
        $this->status;
    }
}
