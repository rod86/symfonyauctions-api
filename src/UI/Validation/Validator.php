<?php

declare(strict_types=1);

namespace App\UI\Validation;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Constraints as Assert;

final class Validator
{
    private ValidatorInterface $validator;

    public function __construct()
    {
        $this->validator = Validation::createValidator();    
    }

    public function validate(array $data, Assert\Collection $rules): array
    {
        $errors = [];
        $violations = $this->validator->validate($data, $rules);
        if ($violations->count()) {
            /** @var ConstraintViolationInterface $violation */
            foreach($violations as $violation) {
                $fieldname = $this->parsePropertyPath($violation->getPropertyPath());
                $errors[$fieldname] = $violation->getMessage();
            }
        }

        return $errors;
    }

    private function parsePropertyPath(string $propertyPath): string 
    {
        return substr($propertyPath, 1, -1);
    }
}