<?php

declare(strict_types=1);

namespace App\Model\Sait\Entity\U4astniks\Personas;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sait_u4astniks_personas")
 */
class Persona
{
    /**
     * @var Id
     * @ORM\Column(type="sait_u4astniks_persona_id")
     * @ORM\Id
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $nomer;


    public function __construct(Id $id, int $nomer)
    {
        $this->id = $id;
        $this->nomer = $nomer;
    }

    public function edit(int $nomer): void
    {
        $this->nomer = $nomer;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getNomer(): int
    {
        return $this->nomer;
    }
	
	public function __toString(): string
    {
        return $this->nomer;
    }
}
