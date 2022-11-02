<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User;

use Webmozart\Assert\Assert;

class UchKak
{
    public const PCHEL = 'ROLE_PCHEL';
    public const MATKO = 'ROLE_MATKO';
    public const PCHMAT = 'ROLE_PCHMAT';
    public const NABLUD = 'ROLE_NABLUD';

    private $name;

    public function __construct(string $name)
    {
        Assert::oneOf($name, [
            self::PCHEL,
            self::MATKO,
            self::PCHMAT,
            self::NABLUD,
        ]);

        $this->name = $name;
    }

    public static function pchel(): self
    {
        return new self(self::PCHEL);
    }

    public static function matko(): self
    {
        return new self(self::MATKO);
    }

    public static function pchmat(): self
    {
        return new self(self::PCHMAT);
    }

    public static function nablud(): self
    {
        return new self(self::NABLUD);
    }

    public function isPchel(): bool
    {
        return $this->name === self::PCHEL;
    }

    public function isMatko(): bool
    {
        return $this->name === self::MATKO;
    }

    public function isPchMat(): bool
    {
        return $this->name === self::PCHMAT;
    }

    public function isNablud(): bool
    {
        return $this->name === self::NABLUD;
    }
// Равнозначно isEqual
    public function isEqual(self $uchkak): bool
    {
        return $this->getName() === $uchkak->getName();
    }

    public function getName(): string
    {
        return $this->name;
    }
}
