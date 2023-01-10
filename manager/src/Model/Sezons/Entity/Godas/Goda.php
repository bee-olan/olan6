<?php

declare(strict_types=1);

namespace App\Model\Sezons\Entity\Godas;

//use App\Model\Paseka\Entity\Uchasties\Group\Group;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sezons_godas")
 */
class Goda
{
    /**
     * @var Id
     * @ORM\Column(type="sezons_goda_id")
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
