<?php

declare(strict_types=1);

namespace App\Tests\Unit\Shared\Domain;

use App\Shared\Domain\ValueObject\Uuid;
use DateTimeImmutable;
use Faker\Factory;
use Faker\Generator;

final class FakeValueGenerator
{
    private const MAX_INT = 2147483647;

    private static ?Generator $faker;

    private static function generator(): Generator
    {
        return self::$faker = self::$faker ?? Factory::create();
    }

    public static function uuid(): Uuid
    {
        return Uuid::fromString(self::generator()->unique()->uuid());
    }

    public static function username(): string
    {
        return self::generator()->unique()->userName();
    }

    public static function email(): string
    {
        return self::generator()->unique()->safeEmail();
    }

    public static function dateTime(): DateTimeImmutable
    {
        return DateTimeImmutable::createFromMutable(self::generator()->dateTimeBetween());
    }

    public static function string(): string
    {
        return self::generator()->word();
    }

    public static function text(): string
    {
        return self::generator()->text();
    }

    public static function plainPassword(): string
    {
        return self::generator()->password(8, 12);
    }

    public static function password(string $plainPassword = null): string
    {
        return password_hash($plainPassword ?? self::plainPassword(), PASSWORD_DEFAULT);
    }

    public static function token(): string
    {
        return self::generator()->sha256();
    }

    public static function integer(int $min = 0, int $max = self::MAX_INT): int
    {
        return self::generator()->numberBetween($min, $max);
    }

    public static function float(int $min = 0, int $max = null, int $decimals = 2): float
    {
        return self::generator()->randomFloat($decimals, $min, $max);
    }

    public static function randomElement(array $options)
    {
        return self::generator()->randomElement($options);
    }
}