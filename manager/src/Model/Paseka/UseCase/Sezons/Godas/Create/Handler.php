<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Godas\Create;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Sezons\Godas\Goda;
use App\Model\Paseka\Entity\Sezons\Godas\Id;
use App\Model\Paseka\Entity\Sezons\Godas\GodaRepository;

//use App\Model\Paseka\Sezons\Godas\Goda;
//use App\Model\Sezons\Entity\Godas\GodaRepository;
//use App\Model\Sezons\Entity\Godas\Id;

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
        $command->sezon = $command->god."-".($command->god + 1);
        $goda = new Goda(
            Id::next(),
            $command->god,
            $command->sezon
        );

        $this->godas->add($goda);

        $this->flusher->flush();
    }
}
