<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Godas\UchasGoda\Add;


use App\Model\Flusher;
use App\Model\Paseka\Entity\Sezons\Godas\GodaRepository;
use App\Model\Paseka\Entity\Sezons\Godas\Id;

use App\Model\Paseka\Entity\Uchasties\Uchastie\UchastieRepository;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Id as UchastieId;

class Handler
{
    private $godas;
    private $uchasties;

    private $flusher;

    public function __construct(
        GodaRepository $godas,
        UchastieRepository $uchasties,
        Flusher $flusher
    )
    {
        $this->godas = $godas;
        $this->uchasties = $uchasties;

        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $goda = $this->godas->get(new Id($command->goda));
        $uchastie = $this->uchasties->get(new UchastieId($command->uchastie));


        $goda->addUchastie($uchastie);

        $this->flusher->flush();
    }
}
