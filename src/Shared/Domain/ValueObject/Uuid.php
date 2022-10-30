<?php

declare(strict_types=1);

namespace App\Shared\Domain\ValueObject;

use Stringable;
use InvalidArgumentException;
use Symfony\Component\Uid\Uuid as SymfonyUuid;

final class Uuid implements Stringable
{
    public function __construct(
        protected readonly string $value
    ) {
        $this->ensureIsValidUuid($value);
    }

    public function equals(Uuid $other): bool
    {
        return $this->value() === $other->value();
    }

    public function value(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value();
    }

    private function ensureIsValidUuid(string $id): void
    {
        if (!SymfonyUuid::isValid($id)) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', Uuid::class, $id));
        }
    }

    public static function fromString(string $value): self
    {
        return new self($value);
    }

    public static function random(): self
    {
        return new Uuid(SymfonyUuid::v4()->toRfc4122());
    }
}
