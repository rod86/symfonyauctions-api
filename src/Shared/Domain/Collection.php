<?php

declare(strict_types=1);

namespace App\Shared\Domain;

use App\Shared\Domain\Aggregate\AggregateRoot;
use ArrayIterator;
use Countable;
use IteratorAggregate;

use function Lambdish\Phunctional\map;

abstract class Collection implements Countable, IteratorAggregate
{
    public function __construct(
        private readonly array $items
    ) {
        Assert::arrayOf($this->type(), $items);
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->items);
    }

    public function items(): array
    {
        return $this->items;
    }

    public function count(): int
    {
        return count($this->items());
    }

    public function toArray(): array
    {
        return map(fn (AggregateRoot $item) => $item->toArray(), $this->items);
    }

    abstract protected function type(): string;
}
