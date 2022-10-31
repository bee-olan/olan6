<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\PlemMatka\Edit;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Matkas\PlemMatka\Id;
use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatkaRepository;
use App\Model\Paseka\Entity\Matkas\Sparings\Id as SparingId;


class Handler
{
    private $plemmatkas;
    private $flusher;

    public function __construct(PlemMatkaRepository $plemmatkas, Flusher $flusher)
    {
        $this->plemmatkas = $plemmatkas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
       // dd($command);
       // $sparing = $this->sparings->get(new SparingId($command->sparing));
        $plemmatka = $this->plemmatkas->get(new Id($command->id));

        $plemmatka->edit(
            $command->title
        );

        $this->flusher->flush();
    }
}
