<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Godas\Edit;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Sezons\Godas\GodaRepository;
use App\Model\Paseka\Entity\Sezons\Godas\Id;

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
        $goda = $this->godas->get(new Id($command->id));

        $goda->edit($command->god, $command->sezon);

        $this->flusher->flush();
    }
}
