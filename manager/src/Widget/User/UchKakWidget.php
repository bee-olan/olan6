<?php

declare(strict_types=1);

namespace App\Widget\User;

use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class UchKakWidget extends AbstractExtension
{
    public function getFunctions(): array
    {
        return [
            new TwigFunction('user_uchkak', [$this, 'uchkak'], ['needs_environment' => true, 'is_safe' => ['html']]),
        ];
    }

    public function uchkak(Environment $twig, string $uchkak): string
    {
        return $twig->render('widget/user/uchkak.html.twig', [
            'uchkak' => $uchkak
        ]);
    }
}
