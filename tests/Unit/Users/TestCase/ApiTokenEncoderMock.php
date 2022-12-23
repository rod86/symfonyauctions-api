<?php

declare(strict_types=1);

namespace App\Tests\Unit\Users\TestCase;

use App\Tests\Unit\Shared\Infrastructure\Testing\AbstractMock;
use App\Users\Domain\Contract\ApiTokenEncoder;

final class ApiTokenEncoderMock extends AbstractMock
{
    protected function getClassName(): string
    {
        return ApiTokenEncoder::class;
    }

    public function shouldEncode(array $payload, string $token): void
    {
        $this->mock
            ->expects($this->once())
            ->method('encode')
            ->with($payload)
            ->willReturn($token);
    }

    public function shouldNotCallEncode(): void
    {
        $this->mock
            ->expects($this->never())
            ->method('encode');
    }
}