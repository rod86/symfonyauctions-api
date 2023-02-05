<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\TestCase;

use App\Shared\Domain\Bus\Event\EventBus;
use App\Tests\Unit\Shared\Infrastructure\Testing\AbstractMock;

final class EventBusMock extends AbstractMock
{
    protected function getClassName(): string
    {
        return EventBus::class;
    }

    public function shouldPublish(): void
    {
        $this->mock
            ->expects($this->once())
            ->method('publish');
    }
}