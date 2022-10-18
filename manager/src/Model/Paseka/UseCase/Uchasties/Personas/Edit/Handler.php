<?php

declare(strict_types=1);

namespace App\Model\Sait\UseCase\U4astniks\Personas\Edit;

use App\Model\Flusher;
use App\Model\Sait\Entity\U4astniks\Personas\Id;
use App\Model\Sait\Entity\U4astniks\Personas\PersonaRepository;

class Handler
{
    private $personas;
    private $flusher;

    public function __construct(GoddRepository $personas, Flusher $flusher)
    {
        $this->personas = $personas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $persona = $this->personas->get(new Id($command->id));

        $persona->edit($command->nomer);

        $this->flusher->flush();
    }
}
