<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\Sparings\Create;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Matkas\Sparings\Sparing;
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
        $sparing = new Sparing(
            Id::next(),
            $command->name,
			$command->title
        );

        $this->sparings->add($sparing);

        $this->flusher->flush();
    }
}
