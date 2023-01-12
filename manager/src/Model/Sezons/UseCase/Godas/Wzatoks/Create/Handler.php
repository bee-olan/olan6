<?php

declare(strict_types=1);

namespace App\Model\Sezons\UseCase\Godas\Wzatoks\Create;

use App\Model\Flusher;
use App\Model\Sezons\Entity\Godas\GodaRepository;
use App\Model\Sezons\Entity\Godas\Id as GodaId;
use App\Model\Sezons\Entity\Godas\Wzatoks\Id;


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
        $goda = $this->godas->get(new GodaId($command->goda));

        $goda->addWzatok(
            Id::next(),
            $command->content,
            $command->kolwz,
            $command->gruppa,
            $command->uchastie

        );

//        $this->godas->add($goda);

        $this->flusher->flush();
    }
}
