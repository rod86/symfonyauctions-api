<?php

declare(strict_types=1);

namespace App\Tests\Unit\Users\Domain\Contract;

use App\Tests\Unit\Shared\Infrastructure\Testing\AbstractMock;
use App\Users\Domain\Contract\PasswordHasher;

final class PasswordHasherMock extends AbstractMock
{
    protected function getClassName(): string
    {
        return PasswordHasher::class;
    }

    public function shouldVerify(string $hashedPassword, string $plainPassword, bool $result): void
    {
        $this->mock
            ->expects($this->testCase->once())
            ->method('verify')
            ->with($hashedPassword, $plainPassword)
            ->willReturn(true);
    }

    public function shouldVerifyFail(string $hashedPassword, string $plainPassword): void
    {
        $this->mock
            ->expects($this->testCase->once())
            ->method('verify')
            ->with($hashedPassword, $plainPassword)
            ->willReturn(false);
    }

    public function shouldNotCallVerify(): void
    {
        $this->mock
            ->expects($this->testCase->never())
            ->method('verify');
    }

    public function shouldHash(string $plainPassword, string $hash): void
    {
        $this->mock
            ->expects($this->testCase->once())
            ->method('hash')
            ->with($plainPassword)
            ->willReturn($hash);
    }

    public function shouldNotCallHash(): void
    {
        $this->mock
            ->expects($this->testCase->never())
            ->method('hash');
    }
}