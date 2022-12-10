<?php

declare(strict_types=1);

namespace App\Shared\Domain;

abstract class DomainException extends \Exception
{
    public function __construct()
    {
        parent::__construct($this->errorMessage());
    }

    abstract public function errorCode(): string;

    abstract public function errorMessage(): string;
}