<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Matkas\ChildMatka;

use Webmozart\Assert\Assert;

class Status
{
    public const NEW = 'Новая';
    public const ZAKAZ = 'Заказана';
    public const WORKING = 'В работе';
    public const HELP = 'Вопрос';
    public const REJECTED = 'Отклонена';
    public const DONE = 'Тест завершено';

    private $name;

    public function __construct(string $name)
    {
        Assert::oneOf($name, [
            self::NEW,
            self::ZAKAZ,
            self::WORKING,
            self::HELP,
            self::REJECTED,
            self::DONE,
        ]);

        $this->name = $name;
    }

    public static function new(): self
    {
        return new self(self::NEW);
    }

    public static function zakaz(): self
    {
        return new self(self::ZAKAZ);
    }

    public static function working(): self
    {
        return new self(self::WORKING);
    }

    public function isEqual(self $other): bool
    {
        return $this->getName() === $other->getName();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isDone(): bool
    {
        return $this->name === self::DONE;
    }

    public function isNew(): bool
    {
        return $this->name === self::NEW;
    }

    public function isZakaz(): bool
    {
        return $this->name === self::ZAKAZ;
    }

    public function isWorking(): bool
    {
        return $this->name === self::WORKING;
    }
}