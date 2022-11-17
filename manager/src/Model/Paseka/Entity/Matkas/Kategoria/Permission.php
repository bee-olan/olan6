<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Matkas\Kategoria;

use Webmozart\Assert\Assert;

class Permission
{
    public const KATEGORIA_DOKUM = 'ПлемМатка: точно есть настоящие  документы';
    public const KATEGORIA_NET_DOKUM = 'Документы на ПлемМатку когда-то были, но ....';
    public const KATEGORIA_I_O = 'ПлемМатка: ио - исскуственно  о ';
    public const KATEGORIA_OSTROV = 'ПлемМатка: ос - островная';
    public const KATEGORIA_TRUT_95 = 'Трутневый фон -- выше 95%';
    public const KATEGORIA_TRUT_90 = 'Трутневый фон -- гарантия 90%';
    public const KATEGORIA_TRUT_NET = 'Целенаправлено вопрос трутневого фона не рассматривается';
    public const KATEGORIA_TRUT_SELEK = 'Селекционная работа  по дедово-отцовской линии';
    public const KATEGORIA_SELEK_RABOT = 'ПлемМатка: серьезная селекционная работа';
    public const KATEGORIA_F_0 = 'ПлемМатка: F0';
    public const KATEGORIA_F_1 = 'ПлемМатка: F1';
    public const KATEGORIA_F_2 = 'ПлемМатка: F2';

    private $name;

    public function __construct(string $name)
    {
        Assert::oneOf($name, self::names());
        $this->name = $name;
    }

    public static function names(): array
    {
        return [
            self::KATEGORIA_DOKUM,
            self::KATEGORIA_NET_DOKUM,
            self::KATEGORIA_I_O,
            self::KATEGORIA_OSTROV,
            self::KATEGORIA_TRUT_95,
            self::KATEGORIA_TRUT_90,
            self::KATEGORIA_TRUT_NET,
            self::KATEGORIA_TRUT_SELEK,
            self::KATEGORIA_SELEK_RABOT,
            self::KATEGORIA_F_0,
            self::KATEGORIA_F_1,
            self::KATEGORIA_F_2
        ];
    }

    public function isNameEqual(string $name): bool
    {
        return $this->name === $name;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
