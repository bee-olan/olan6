<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Matkas\ChildMatka;

use Webmozart\Assert\Assert;

class Type
{
    public const AWTOR = 'Автор';
    public const AWTORTEST = 'Автор-Тестирующий';
    public const TESTIR = 'Тестирующий';
    public const NABLUD = 'Наблюдатель';
    public const MESTN = 'Мес';
    

    private $name;

    public function __construct(string $name)
    {
        Assert::oneOf($name, [
            self::AWTOR,
            self::AWTORTEST,
            self::TESTIR,
            self::NABLUD,
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
