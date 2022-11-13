<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\PlemMatka\Uchastnik\Remove;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Matkas\PlemMatka\Id;
use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatkaRepository;
use App\Model\Paseka\Entity\Uchasties\Uchastie\UchastieRepository;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Id as UchastieId;

class Handler
{
    private $plemmatkas;
    private $flusher;
    private $uchasties;

    public function __construct(
        PlemMatkaRepository $plemmatkas,
        UchastieRepository $uchasties,
        Flusher $flusher
    )
    {
        $this->plemmatkas = $plemmatkas;
        $this->flusher = $flusher;
        $this->uchasties = $uchasties;
    }

    public function handle(Command $command): void
    {
        $plemmatka = $this->plemmatkas->get(new Id($command->plemmatka));
        $uchastie = $this->uchasties->get(new UchastieId($command->uchastie));

        $plemmatka->removeUchastie($uchastie->getId());

        $this->flusher->flush();
    }
}

