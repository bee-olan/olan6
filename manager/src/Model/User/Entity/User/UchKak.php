<?php

declare(strict_types=1);

namespace App\Model\User\Entity\User;

use Webmozart\Assert\Assert;

class UchKak
{
    public const PCHEL = 'ROLE_PCHEL';
    public const MATKO = 'ROLE_MATKO';
    public const PCHMAT = 'ROLE_PCHMAT';

    private $name;

    public function __construct(string $name)
    {
        Assert::oneOf($name, [
            self::PCHEL,
            self::MATKO,
            self::PCHMAT,
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

    public function isEqual(self $uchKak): bool
    {
        return $this->getName() === $uchKak->getName();
    }

    public function getName(): string
    {
        return $this->name;
    }
}
