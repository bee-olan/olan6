<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Matkas\ChildMatka;

use Webmozart\Assert\Assert;

class Type
{
    public const NONE = 'none';
    public const ERROR = 'error';
    public const SVOBODNA = 'Свободна';

    private $name;

    public function __construct(string $name)
    {
        Assert::oneOf($name, [
            self::NONE,
            self::ERROR,
            self::SVOBODNA,
        ]);

        $this->name = $name;
    }

    public function isEqual(self $other): bool
    {
        return $this->getName() === $other->getName();
    }

    public function getName(): string
    {
        return $this->name;
    }
}
