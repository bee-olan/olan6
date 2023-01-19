<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Tochkas\Create;

use App\Model\Flusher;

use App\Model\Paseka\Entity\Sezons\Tochkas\Id;
use App\ReadModel\Paseka\Sezons\Godas\UchasGodaFetcher;

class Handler
{
    private $uchasgodas;
    private $flusher;

    public function __construct(UchasGodaFetcher $uchasgodas, Flusher $flusher)
    {
        $this->uchasgodas = $uchasgodas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {

        $uchasgoda = $this->uchasgodas->getUchas($command->uchasgoda);
//        dd($uchasgoda);
        $uchasgoda->addTochka(
            Id::next(),
            $command->kolwz,
            $command->gruppa,
            $command->name
                );

        $this->flusher->flush();
    }
}
