<?php

declare(strict_types=1);

namespace App\Tests\Unit\Users\TestCase;

use App\Shared\Domain\ValueObject\Uuid;
use App\Tests\Unit\Shared\Infrastructure\Testing\AbstractMock;
use App\Users\Domain\Contract\UserRepository;
use App\Users\Domain\User;

final class UserRepositoryMock extends AbstractMock
{
    protected function getClassName(): string
    {
        return UserRepository::class;
    }

    public function shouldFindUserByUsername(string $username, string $email, User $user): void
    {
        $this->mock
            ->expects($this->once())
            ->method('findUserByUsernameOrEmail')
            ->with($username, $email)
            ->willReturn($user);
    }

    public function shouldNotFindUserByUsername(string $username, string $email): void
    {
        $this->mock
            ->expects($this->once())
            ->method('findUserByUsernameOrEmail')
            ->with($username, $email)
            ->willReturn(null);
    }

    public function shouldCreate(User $user): void
    {
        $this->mock
            ->expects($this->once())
            ->method('create')
            ->with($user);
    }

    public function shouldFindUserById(Uuid $id, User $user): void
    {
        $this->mock
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn($user);
    }

    public function shouldNotFindUserById(Uuid $id): void
    {
        $this->mock
            ->expects($this->once())
            ->method('findById')
            ->with($id)
            ->willReturn(null);
    }
}