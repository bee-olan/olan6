<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\PlemMatka\Create;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatka;
use App\Model\Paseka\Entity\Matkas\PlemMatka\Id;
use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatkaRepository;
use App\Model\Paseka\Entity\Matkas\Sparings\SparingRepository;
use App\Model\Paseka\Entity\Matkas\Sparings\Id as SparingId;

class Handler
{
    private $plemmatkas;
    private $sparings;
    private $flusher;

    public function __construct(PlemMatkaRepository $plemmatkas,
                                SparingRepository $sparings,
                                Flusher $flusher)
    {
        $this->plemmatkas = $plemmatkas;
        $this->sparings = $sparings;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $sparing = $this->sparings->get(new SparingId($command->sparing));
//dd($sparing->getName());
        $plemmatka = new PlemMatka(
            Id::next(),
            $sparing,
            $command->name = $command->name."_".$sparing->getName(),
            $command->sort
        );

        $this->plemmatkas->add($plemmatka);

        $this->flusher->flush();
    }
}
