<?php

declare(strict_types=1);

namespace App\Model\Mesto\UseCase\Okrugs\Oblasts\Raions\Edit;

use App\Model\Flusher;
use App\Model\Mesto\Entity\Okrugs\Oblasts\Raions\RaionRepository;


class Handler
{
    private $raions;
    private $flusher;

    public function __construct(RaionRepository $raions, Flusher $flusher)
    {
        $this->raions = $raions;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $raion = $this->raions->get(new Id($command->id));

        $raion->edit($command->name, $command->nomer, $command->mesto);

        $this->flusher->flush();
    }
}
