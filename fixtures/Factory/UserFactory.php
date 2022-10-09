<?php

declare(strict_types=1);

namespace App\Fixtures\Factory;

use App\Shared\Domain\ValueObject\Uuid;
use App\Users\Domain\User;
use DateTimeImmutable;

final class UserFactory extends ModelFactory
{
    private const DEFAULT_PASSWORD = '$2y$13$/66pgZrdoAwDzx7JMEwz3eCuhcjXfqE2rZ1bYKD5pwfe9sflhaYAK'; //123456

    protected function getModelClass(): string
    {
        return User::class;
    }

    protected function getDefaultAttributes(): array
    {
        return [
            'id' => Uuid::random(),
            'username' => $this->faker()->unique()->userName(),
            'email' => $this->faker()->unique()->safeEmail(),
            'password' => self::DEFAULT_PASSWORD,
            'createdAt' => DateTimeImmutable::createFromMutable($this->faker()->dateTimeBetween('-1 year')),
            'updatedAt' => DateTimeImmutable::createFromMutable($this->faker()->dateTimeBetween('-1 year'))
        ];
    }
}