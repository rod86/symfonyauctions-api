<?php

namespace App\Shared\Infrastructure\Bus\Exception;

use App\Shared\Domain\Bus\Query\Query;

class QueryNotRegisteredError extends \Exception
{
    public function __construct(Query $query)
    {
        $message = sprintf(
            'Query with class %s has no handler registered',
            get_class($query)
        );

        parent::__construct($message);
    }
}
