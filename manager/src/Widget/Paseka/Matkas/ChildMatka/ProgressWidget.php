<?php

declare(strict_types=1);

namespace App\Widget\Paseka\Matkas\ChildMatka;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ProgressWidget extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('paseka_matkas_childmatka_progress', [$this, 'progress'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    public function progress(Environment $twig, int $progress): string
    {
        return $twig->render('widget/paseka/matkas/childmatka/progress.html.twig', [
            'progress' => $progress
        ]);
    }
}
