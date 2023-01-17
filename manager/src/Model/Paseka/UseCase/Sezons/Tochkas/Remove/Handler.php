<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Tochkas\Remove;

use App\Model\Flusher;
//use App\Model\Paseka\Entity\Rasas\RasaRepository;
//use App\Model\Paseka\Entity\Rasas\Id;

class Handler
{
    private $rasas;
    private $flusher;

    public function __construct(RasaRepository $rasas, Flusher $flusher)
    {
        $this->rasas = $rasas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $rasa = $this->rasas->get(new Id($command->id));

        $this->rasas->remove($rasa);

        $this->flusher->flush();
    }
}
