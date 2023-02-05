<?php

declare(strict_types=1);

namespace App\Tests\Unit\Users\TestCase;

use App\Shared\Domain\ValueObject\Uuid;
use App\Tests\Unit\Shared\Infrastructure\Testing\AbstractMock;
use App\Users\Domain\DomainService\FindUserById;
use App\Users\Domain\User;

final class FindUserByIdMock extends AbstractMock
{
    protected function getClassName(): string
    {
        return FindUserById::class;
    }

    public function shouldReturnUser(Uuid $id, User $user): void
    {
        $this->mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($id)
            ->willReturn($user);
    }
}