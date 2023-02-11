<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Domain;

use function Lambdish\Phunctional\repeat;

final class Repeater
{
    private const MAX_TIMES = 5;

    public static function repeat(callable $function, int $times): array
    {
        return repeat($function, $times);
    }

    public static function random(callable $function): array
    {
        return self::repeat($function, FakeValueGenerator::integer(1, self::MAX_TIMES));
    }
}