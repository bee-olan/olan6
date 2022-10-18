<?php

declare(strict_types=1);

namespace App\Model\Sait\UseCase\U4astniks\Personas\Edit;

use App\Model\Sait\Entity\U4astniks\Personas\Personas;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $id;
	
    /**
     * @Assert\NotBlank()
     */
    public $nomer;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromPersona(Personas $persona): self
    {
        $command = new self($persona->getId()->getValue());
        $command->nomer = $persona->getNomer();
        return $command;
    }
}
