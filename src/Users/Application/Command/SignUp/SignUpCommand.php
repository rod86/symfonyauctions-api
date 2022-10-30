<?php

declare(strict_types=1);

namespace App\Users\Application\Command\SignUp;

use App\Shared\Domain\Bus\Command\Command;
use DateTimeImmutable;

class SignUpCommand implements Command
{
    public function __construct(
        private readonly string $id,
        private readonly string $username,
        private readonly string $email,
        private readonly string $plainPassword,
        private readonly DateTimeImmutable $createdAt,
        private readonly DateTimeImmutable $updatedAt,
    ) {}

    public function id(): string
	{
		return $this->id;
	}

    public function username(): string
    {
        return $this->username;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function plainPassword(): string
    {
        return $this->plainPassword;
    }

    public function createdAt(): DateTimeImmutable
	{
		return $this->createdAt;
	}

	public function updatedAt(): DateTimeImmutable
	{
		return $this->updatedAt;
	}
}
