<?php

namespace App\Shared\Infrastructure\Bus\Exception;

use App\Shared\Domain\Bus\Command\Command;

class CommandNotRegisteredException extends \Exception
{
    public function __construct(Command $command)
    {
        $message = sprintf(
            'Command with class %s has no handler registered',
            get_class($command)
        );

        parent::__construct($message);
    }
}
