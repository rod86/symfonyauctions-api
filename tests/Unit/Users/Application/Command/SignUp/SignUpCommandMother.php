<?php

declare(strict_types=1);

namespace App\Tests\Unit\Users\Application\Command\SignUp;

use App\Tests\Unit\Shared\Domain\FakeValueGenerator;
use App\Users\Application\Command\SignUp\SignUpCommand;
use App\Users\Domain\User;
use DateTimeImmutable;

final class SignUpCommandMother
{
    public static function create(
        string $id = null,
        string $username = null,
        string $email = null,
        string $plainPassword = null,
        DateTimeImmutable $createdAt = null,
        DateTimeImmutable $updatedAt = null
    ): SignUpCommand {
        return new SignUpCommand(
            id: $id ?? FakeValueGenerator::uuid()->value(),
            username: $username ?? FakeValueGenerator::username(),
            email: $email ?? FakeValueGenerator::email(),
            plainPassword: $plainPassword ?? FakeValueGenerator::plainPassword(),
            createdAt: $createdAt ?? FakeValueGenerator::dateTime(),
            updatedAt: $updatedAt ?? FakeValueGenerator::dateTime()
        );
    }

    public static function createFromUser(User $user, string $plainPassword = null): SignUpCommand
    {
        return self::create(
            id: $user->id()->value(),
            username: $user->username(),
            email: $user->email(),
            plainPassword: $plainPassword ?? FakeValueGenerator::plainPassword(),
            createdAt: $user->createdAt(),
            updatedAt: $user->updatedAt()
        );
    }
}