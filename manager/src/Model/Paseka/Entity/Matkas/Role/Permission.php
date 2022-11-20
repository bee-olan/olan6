<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Matkas\Role;

use Webmozart\Assert\Assert;

class Permission
{
    public const MANAGE_PLEMMATKA_UCHASTIES = 'Участие в регистрации ПлемМаток';
    public const VIEW_CHILDMATKAS = 'Смотреть ДочьМаток';
    public const ZAKAZ_CHILDMATKAS = 'Заказывать   ДочьМаток';
    public const MANAGE_CHILDMATKAS_UCHASTIES = 'Участие в регистрации ДочьМаток';

    private $name;

    public function __construct(string $name)
    {
        Assert::oneOf($name, self::names());
        $this->name = $name;
    }

    public static function names(): array
    {
        return [
            self::MANAGE_PLEMMATKA_UCHASTIES,
            self::MANAGE_CHILDMATKAS_UCHASTIES,
            self::VIEW_CHILDMATKAS,
            self::ZAKAZ_CHILDMATKAS,
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