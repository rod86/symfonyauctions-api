<?php

declare(strict_types=1);

namespace App\Notifications\Infrastructure\Template\Twig;

use App\Notifications\Domain\Contract\TemplateInterface;
use Twig\Environment;

final class TwigTemplate implements TemplateInterface
{
    public function __construct(
        private readonly Environment $twig
    ) {}

    public function render(string $template, array $data = []): string
    {
        return $this->twig->render($template, $data);
    }
}