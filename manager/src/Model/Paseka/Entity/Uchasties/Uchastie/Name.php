<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Uchasties\Uchastie;

use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * @ORM\Embeddable
 */
class Name
{
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $first;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $last;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $nike;

    public function __construct(string $first, string $last,  string $nike)
    {
        Assert::notEmpty($first);
        Assert::notEmpty($last);
        Assert::notEmpty($nike);

        $this->first = $first;
        $this->last = $last;
        $this->nike = $nike;
    }

    public function getFirst(): string
    {
        return $this->first;
    }

    public function getLast(): string
    {
        return $this->last;
    }

    public function getNike(): string
    {
        return $this->last;
    }

    public function getFull(): string
    {
        return $this->first . ' ' . $this->last;
    }
}

