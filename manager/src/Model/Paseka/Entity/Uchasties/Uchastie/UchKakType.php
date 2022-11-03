<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Uchasties\Uchastie;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;

class UchKakType extends StringType
{
    public const NAME = 'paseka_uchasties_uchastie_uchkak';

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof UchKak ? $value->getName() : $value;
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? new UchKak($value) : null;
    }

    public function getName(): string
    {
        return self::NAME;
    }
}
