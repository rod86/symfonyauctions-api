<?php

declare(strict_types=1);

namespace App\Auctions\Domain\Exception;

class InvalidBidException extends \Exception
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}