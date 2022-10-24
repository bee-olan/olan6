<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Rasas\Linias\Nomers\Create;


use App\Model\Flusher;

use App\Model\Paseka\Entity\Rasas\Linias\LiniaRepository;
use App\Model\Paseka\Entity\Rasas\Linias\Id as LiniaId;

use App\Model\Paseka\Entity\Rasas\Linias\Nomers\Id;



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

        $linia = $this->linias->get(new LiniaId($command->linia));

        $linia->addNomer(
            Id::next(),
            $command->name ,
            $command->nameStar,
            $command->title,
            $command->sortNomer
        );
        $this->flusher->flush();
    }
}
