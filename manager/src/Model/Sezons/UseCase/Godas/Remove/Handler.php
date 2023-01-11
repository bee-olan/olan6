<?php

declare(strict_types=1);

namespace App\Model\Sezons\UseCase\Godas\Remove;

use App\Model\Flusher;


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
