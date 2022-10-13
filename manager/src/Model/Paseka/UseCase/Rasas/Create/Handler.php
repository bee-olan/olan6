<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Rasas\Create;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Rasas\Rasa;
use App\Model\Paseka\Entity\Rasas\Id;
use App\Model\Paseka\Entity\Rasas\RasaRepository;

class Handler
{
    private $rasas;
    private $flusher;

    public function __construct(RasaRepository $rasas, Flusher $flusher)
    {
        $this->rasas = $rasas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $rasa = new Rasa(
            Id::next(),
            $command->name,
			$command->title
        );

        $this->rasas->add($rasa);

        $this->flusher->flush();
    }
}
