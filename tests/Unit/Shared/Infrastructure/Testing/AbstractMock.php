<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Infrastructure\Testing;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

abstract class AbstractMock
{
    protected MockObject $mock;

    public function __construct(
        protected readonly TestCase $testCase
    ) {
        $this->mock = $this->testCase->getMockBuilder($this->getClassName())
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function getMock(): MockObject
    {
        return $this->mock;
    }

    abstract protected function getClassName(): string;
}