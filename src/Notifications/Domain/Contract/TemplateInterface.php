<?php

declare(strict_types=1);

namespace App\Notifications\Domain\Contract;

interface TemplateInterface
{
    public function render(string $template, array $data = []): string;
}