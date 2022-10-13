<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Rasas\Linias\Nomers\Edit;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Rasas\Linias\Nomers\Id as NomerId;
use App\Model\Paseka\Entity\Rasas\Linias\Id;
use App\Model\Paseka\Entity\Rasas\Linias\LiniaRepository;

class Handler
{
    private $linias;
    private $flusher;

    public function __construct(LiniaRepository $linias, Flusher $flusher)
    {
        $this->linias = $linias;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $linia = $this->linias->get(new Id($command->linia));

        $linia->editNomer(new NomerId($command->id),
										$command->name, 
										$command->nameStar, 
										$command->title);

        $this->flusher->flush();
    }
}

