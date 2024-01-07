<?php

namespace App\Core\User\Application\DTO;

class EmailDTO
{
    public function __construct(
        public readonly string $email
    ) {}
}