<?php

declare(strict_types=1);

namespace App\Shared\Domain\Aggregate;

use DateTimeImmutable;

trait Timestampable
{
    private DateTimeImmutable $createdAt;
    private DateTimeImmutable $updatedAt;

    public function updatedAt(): DateTimeImmutable
	{
		return $this->updatedAt;
	}

	public function createdAt(): DateTimeImmutable
	{
		return $this->createdAt;
	}

    public function updateCreatedAt(DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function updateUpdatedAt(DateTimeImmutable $updatedAt): void 
    {
        $this->updatedAt = $updatedAt;
    }
}
