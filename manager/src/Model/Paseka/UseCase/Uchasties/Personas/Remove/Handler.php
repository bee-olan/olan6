<?php

declare(strict_types=1);

namespace App\Model\Sait\UseCase\U4astniks\Personas\Remove;

use App\Model\Flusher;
use App\Model\Sait\Entity\U4astniks\Personas\PersonaRepository;
use App\Model\Sait\Entity\U4astniks\Personas\Id;
// use App\Model\Sait\Entity\U4astniks\U4astnik\U4astnikRepository;

class Handler
{
    private $personas;
    // private $u4astniks;
    private $flusher;
// U4astnikRepository  $u4astniks,
    public function __construct(PersonaRepository $personas,                               
                                Flusher $flusher)
    {
        $this->personas = $personas;
        // $this->u4astniks = $u4astniks;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $persona = $this->personas->get(new Id($command->id));

        // if ($this->u4astniks->hasByGroup($persona->getId())) {
        //     throw new \DomainException('Personas is not empty.');
        // }


        $this->personas->remove($persona);

        $this->flusher->flush();
    }
}
