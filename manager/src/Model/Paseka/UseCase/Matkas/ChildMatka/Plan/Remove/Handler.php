<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\ChildMatka\Plan\Remove;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Id as UchastieId;
use App\Model\Paseka\Entity\Uchasties\Uchastie\UchastieRepository;
use App\Model\Paseka\Entity\Matkas\ChildMatka\Id;
use App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatkaRepository;

class Handler
{
    private $childmatkas;
    private $flusher;
    private $uchastes;

    public function __construct(
        ChildMatkaRepository $childmatkas,
        UchastieRepository $uchastes,
        Flusher $flusher
    )
    {
        $this->childmatkas = $childmatkas;
        $this->flusher = $flusher;
        $this->uchastes = $uchastes;
    }

    public function handle(Command $command): void
    {
        $actor = $this->uchastes->get(new UchastieId($command->actor));
        $childmatka = $this->childmatkas->get(new Id($command->id));

        $childmatka->removePlan($actor, new \DateTimeImmutable(), null);

        $this->flusher->flush();
    }
}
