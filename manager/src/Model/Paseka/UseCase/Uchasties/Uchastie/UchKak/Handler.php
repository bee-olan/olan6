<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Uchasties\Uchastie\UchKak;

use App\Model\Flusher;

use App\Model\Paseka\Entity\Uchasties\Uchastie\UchastieRepository;
use App\Model\Paseka\Entity\Uchasties\Uchastie\UchKak;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Id;


class Handler
{
    private $uchasties;
    private $flusher;

    public function __construct(UchastieRepository $uchasties, Flusher $flusher)
    {
        $this->uchasties = $uchasties;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $user = $this->uchasties->get(new Id($command->id));

        $user->changeUchKak(new UchKak($command->uchkak));

        $this->flusher->flush();
    }
}
