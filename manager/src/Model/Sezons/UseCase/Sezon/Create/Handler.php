<?php

declare(strict_types=1);

namespace App\Model\Sezons\UseCase\Sezon\Create;

use App\Model\Flusher;

use App\Model\Sezons\Entity\Sezon\Sezon;
use App\Model\Sezons\Entity\Sezon\SezonRepository;
use App\Model\Sezons\Entity\Sezon\Id;

class Handler
{
    private $sezons;
    private $flusher;

    public function __construct(SezonRepository $sezons, Flusher $flusher)
    {
        $this->sezons = $sezons;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {

        $sezon = new Sezon(
            Id::next(),
            $command->god,
            $command->sezon
        );

        $this->sezons->add($sezon);

        $this->flusher->flush();
    }
}
