<?php

declare(strict_types=1);

namespace App\Users\Domain;

use App\Shared\Domain\Aggregate\AggregateRoot;
use App\Shared\Domain\Aggregate\Timestampable;
use App\Shared\Domain\ValueObject\Uuid;
use DateTimeImmutable;

class User extends AggregateRoot
{
    use Timestampable;

    public function __construct(
        private Uuid $id,
        private readonly string $username,
        private readonly string $email,
        private readonly string $password,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt,
    ) {
        $this->updateCreatedAt($createdAt);
        $this->updateUpdatedAt($updatedAt);
    }

    public function id(): Uuid
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

    public function password(): string
    {
        return $this->password;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id->value(),
            'username' => $this->username,
            'email' => $this->email,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ];
    }
}
