<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Matkas\Role;

use Webmozart\Assert\Assert;

class Permission
{
    public const MANAGE_PLEMMATKA_UCHASTIES = 'Registr_PlemMatok';
    public const VIEW_CHILDMATKAS = 'Смотреть ДочьМаток';
    public const MANAGE_CHILDMATKAS = 'Создавать\редактировать ДочьМаток';
    public const ZAKAZ_CHILDMATKAS = 'Заказывать   ДочьМаток';
    public const MANAGE_CHILDMATKAS_UCHASTIES = 'Участие в регистрации ДочьМаток';
    public const ADMIN_MATKA = 'Редактировать и удалять';

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
            self::MANAGE_CHILDMATKAS,
            self::ZAKAZ_CHILDMATKAS,
            self::ADMIN_MATKA,
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
