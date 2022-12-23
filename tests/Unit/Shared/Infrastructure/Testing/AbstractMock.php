<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Infrastructure\Testing;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\MockObject\Rule\InvokedCount as InvokedCountMatcher;
use PHPUnit\Framework\TestCase;

abstract class AbstractMock
{
    protected MockObject $mock;

    public function __construct(
        private readonly TestCase $testCase
    ) {
        $this->mock = $this->testCase->getMockBuilder($this->getClassName())
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function getMock(): MockObject
    {
        return $this->mock;
    }

    protected function once(): InvokedCountMatcher
    {
        return $this->testCase->once();
    }

    protected function never(): InvokedCountMatcher
    {
        return $this->testCase->never();
    }

    protected function exactly(int $count): InvokedCountMatcher
    {
        return $this->testCase->exactly($count);
    }

    abstract protected function getClassName(): string;
}