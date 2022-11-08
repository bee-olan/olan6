<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\ChildMatka\Plan\Set;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Id as UchastieId;
use App\Model\Paseka\Entity\Uchasties\Uchastie\UchastieRepository;
use App\Model\Paseka\Entity\Matkas\ChildMatka\Id;
use App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatkaRepository;

class Handler
{
    private $uchastes;
    private $childmatkas;
    private $flusher;

    public function __construct(
        UchastieRepository $uchastes,
        ChildMatkaRepository $childmatkas,
        Flusher $flusher
    )
    {
        $this->uchastes = $uchastes;
        $this->childmatkas = $childmatkas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $actor = $this->uchastes->get(new UchastieId($command->actor));
        $childmatka = $this->childmatkas->get(new Id($command->id));

        $childmatka->plan($actor, new \DateTimeImmutable(), $command->date);

        $this->flusher->flush($childmatka);
    }
}
