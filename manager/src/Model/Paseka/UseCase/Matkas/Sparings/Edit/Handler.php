<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\Sparings\Edit;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Matkas\Sparings\Id;
use App\Model\Paseka\Entity\Matkas\Sparings\SparingRepository;

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

        $sparing->edit($command->name, $command->title);

        $this->flusher->flush();
    }
}
