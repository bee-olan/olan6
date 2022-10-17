<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Uchasties\Uchastie\Edit;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Email;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Id;
use App\Model\Paseka\Entity\Uchasties\Uchastie\UchastieRepository;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Name;

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
        $uchastie = $this->uchasties->get(new Id($command->id));

        $uchastie->edit(
            new Name(
                $command->firstName,
                $command->lastName
            ),
            new Email($command->email)
        );

        $this->flusher->flush();
    }
}