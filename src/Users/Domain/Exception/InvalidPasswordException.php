<?php

declare(strict_types=1);

namespace App\Users\Domain\Exception;

class InvalidPasswordException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Invalid password.');
    }
}