<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Rasas\Linias\Nomers\Create;

use App\Model\Flusher;

use App\Model\Paseka\Entity\Rasas\Linias\Nomers\Sparings\SparingRepository;
use App\Model\Paseka\Entity\Rasas\Linias\Nomers\Sparings\Id as SparingId;

use App\Model\Paseka\Entity\Rasas\Linias\Nomers\Id;
use App\Model\Paseka\Entity\Rasas\Linias\Id as LiniaId;
use App\Model\Paseka\Entity\Rasas\Linias\LiniaRepository;

class Handler
{
    private $linias;
    private $sparings;
    private $flusher;

    public function __construct(LiniaRepository $linias, 
                                SparingRepository $sparings, 
                                Flusher $flusher)
    {
        $this->linias = $linias;
        $this->sparings = $sparings;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $linia = $this->linias->get(new LiniaId($command->linia));

        $sparing = $this->sparings->get(new SparingId($command->sparing));

        $linia->addNomer(
            Id::next(),
            $sparing,
            $command->name ,
			$command->nameStar,
            $command->title,
            $command->sortNomer
        );

        $this->flusher->flush();
    }
}
