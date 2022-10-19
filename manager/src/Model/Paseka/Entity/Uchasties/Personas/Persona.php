<?php


namespace App\Model\Paseka\Entity\Uchasties\Personas;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="paseka_uchasties_personas")
 */
class Persona
{
    /**
     * @var Id
     * @ORM\Column(type="paseka_uchasties_persona_id")
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


}
