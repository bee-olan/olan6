<?php

declare(strict_types=1);

namespace App\Model\Sezons\UseCase\Godas\Create;

use App\Model\Flusher;
use App\Model\Sezons\Entity\Godas\Goda;
use App\Model\Sezons\Entity\Godas\GodaRepository;
use App\Model\Sezons\Entity\Godas\Id;

class Handler
{
    private $godas;
    private $flusher;

    public function __construct(GodaRepository $godas, Flusher $flusher)
    {
        $this->godas = $godas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {

        $goda = new Goda(
            Id::next(),
            $command->god,
            $command->sezon
        );

        $this->godas->add($goda);

        $this->flusher->flush();
    }
}