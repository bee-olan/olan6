<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Matkas\ChildMatka;

use Webmozart\Assert\Assert;

class Type
{
    public const ELIT = 'Эли';
    public const BREND = 'Бре';
    public const ADAPT = 'Ада';
    public const MESTN = 'Мес';

    private $name;

    public function __construct(string $name)
    {
        Assert::oneOf($name, [
            self::ELIT,
            self::BREND,
            self::ADAPT,
            self::MESTN,
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
