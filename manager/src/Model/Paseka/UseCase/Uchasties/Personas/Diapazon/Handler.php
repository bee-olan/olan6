<?php


namespace App\Model\Paseka\UseCase\Uchasties\Personas\Diapazon;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Uchasties\Personas\Persona;
use App\Model\Paseka\Entity\Uchasties\Personas\Id;
use App\Model\Paseka\Entity\Uchasties\Personas\PersonaRepository;

class Handler
{
    // private $personas;
    // private $flusher;

    // public function __construct(PersonaRepository $personas, Flusher $flusher)
    // {
    //     $this->personas = $personas;
    //     $this->flusher = $flusher;
    // }

    public function handle(Command $command): void
    {


        // $persona = new Persona(
        //     Id::next(),
        //     $command->nomer
        // );

        // $this->personas->add($persona);

        // $this->flusher->flush();
    }
}
