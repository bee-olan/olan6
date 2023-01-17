<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Tochkas\Create;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Sezons\Godas\GodaRepository;
use App\Model\Paseka\Entity\Sezons\Godas\Id as GodaId;

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

        $uchasgoda = $this->godas->getUchas(new GodaId($command->uchasgoda));

        $uchasgoda->addTochka(
            Id::next(),
            $command->kolwz,
            $command->gruppa
                );

        $this->flusher->flush();
    }
}
