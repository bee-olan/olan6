<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\Sparings\Remove;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Matkas\Sparings\SparingRepository;
use App\Model\Paseka\Entity\Matkas\Sparings\Id;

class Handler
{
    private $sparings;
    private $flusher;

    public function __construct(SparingRepository $sparings, Flusher $flusher)
    {
        $this->sparings = $sparings;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $sparing = $this->sparings->get(new Id($command->id));

        $this->sparings->remove($sparing);

        $this->flusher->flush();
    }
}
