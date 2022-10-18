<?php

declare(strict_types=1);

namespace App\Model\Sait\UseCase\U4astniks\Personas\Create;

use App\Model\Flusher;
use App\Model\Sait\Entity\U4astniks\Personas\Persona;
use App\Model\Sait\Entity\U4astniks\Personas\Id;
use App\Model\Sait\Entity\U4astniks\Personas\PersonaRepository;

class Handler
{
    private $personas;
    private $flusher;

    public function __construct(PersonaRepository $personas, Flusher $flusher)
    {
        $this->personas = $personas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $persona = new Persona(
            Id::next(),
            $command->nomer
        );

        $this->personas->add($persona);

        $this->flusher->flush();
    }
}
