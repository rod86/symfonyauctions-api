<?php

declare(strict_types=1);

namespace App\Users\Application\Query\Authenticate;

use App\Shared\Domain\Bus\Query\Query;

class AuthenticateQuery implements Query
{
    public function __construct(
        private readonly string $username,
        private readonly string $plainPassword,
    ) {}

    public function username(): string
    {
        return $this->username;
    }

    public function plainPassword(): string
    {
        return $this->plainPassword;
    }
}
