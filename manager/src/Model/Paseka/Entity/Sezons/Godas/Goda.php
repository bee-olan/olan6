<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Sezons\Godas;

use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="paseka_sezons_godas")
 */
class Goda
{
    /**
     * @var Id
     * @ORM\Column(type="paseka_sezons_goda_id")
     * @ORM\Id
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $god;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $sezon;


    public function __construct(Id $id, int $god , string $sezon)
    {
        $this->id = $id;
        $this->god = $god;
        $this->sezon = $sezon;
    }

    public function edit(int $god, string $sezon): void
    {
        $this->god = $god;
        $this->sezon = $sezon;
    }
/////////////////////////
    public function getId(): Id
    {
        return $this->id;
    }

    public function getGod(): int
    {
        return $this->god;
    }

    public function getSezon(): string
    {
        return $this->sezon;
    }
}
