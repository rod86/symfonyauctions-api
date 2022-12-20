<?php

declare(strict_types=1);

namespace App\Tests\Unit\Users\Domain;

use App\Shared\Domain\ValueObject\Uuid;
use App\Tests\Unit\Shared\Domain\FakeValueGenerator;
use App\Users\Domain\User;
use DateTimeImmutable;

final class UserMother
{
    public static function create(
        Uuid $id = null,
        string $username = null,
        string $email = null,
        string $password = null,
        DateTimeImmutable $createdAt = null,
        DateTimeImmutable $updatedAt = null
    ): User {
        return new User(
            id: $id ?? FakeValueGenerator::uuid(),
            username: $username ?? FakeValueGenerator::username(),
            email: $email ?? FakeValueGenerator::email(),
            password: $password ?? FakeValueGenerator::password(),
            createdAt: $createdAt ?? FakeValueGenerator::dateTime(),
            updatedAt: $updatedAt ?? FakeValueGenerator::dateTime()
        );
    }
}