<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Godas\UchasGoda\Edit;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Sezons\Godas\GodaRepository;


class Handler
{
    private $uchasgodas;
    private $flusher;

    public function __construct(GodaRepository $uchasgodas, Flusher $flusher)
    {
        $this->uchasgodas = $uchasgodas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $uchasgoda = $this->uchasgodas->get(new Id($command->id));

        $uchasgoda->edit($command->koltochek);

        $this->flusher->flush();
    }
}
