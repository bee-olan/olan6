<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\ChildMatka\Executor\Revoke;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Id as UchastieId;
use App\Model\Paseka\Entity\Uchasties\Uchastie\UchastieRepository;
use App\Model\Paseka\Entity\Matkas\ChildMatka\Id;
use App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatkaRepository;

class Handler
{
    private $childmatkas;
    private $flusher;
    private $uchasties;

    public function __construct(
        ChildMatkaRepository $childmatkas,
        UchastieRepository $uchasties,
        Flusher $flusher
    )
    {
        $this->childmatkas = $childmatkas;
        $this->flusher = $flusher;
        $this->uchasties = $uchasties;
    }

    public function handle(Command $command): void
    {
        $actor = $this->uchasties->get(new UchastieId($command->actor));
        $childmatka = $this->childmatkas->get(new Id($command->id));
        $uchastie = $this->uchasties->get(new UchastieId($command->uchastie));

        $childmatka->revokeExecutor($actor, new \DateTimeImmutable(),$uchastie->getId());

        $this->flusher->flush();
    }
}

