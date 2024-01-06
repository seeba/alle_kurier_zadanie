<?php

namespace App\Core\User\Domain\ValueObject;

class Email
{
    public function __construct(
        public readonly string $email
    ) {}
}