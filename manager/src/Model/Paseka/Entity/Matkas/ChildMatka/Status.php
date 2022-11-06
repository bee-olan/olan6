<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Matkas\ChildMatka;

use Webmozart\Assert\Assert;

class Status
{
    public const NEW = 'новая';
    public const WORKING = 'в работе';
    public const HELP = 'вопрос';
    public const REJECTED = 'отклонена';
    public const DONE = 'сделано';

    private $name;

    public function __construct(string $name)
    {
        Assert::oneOf($name, [
            self::NEW,
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
}