<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\ChildMatka\ChildOf;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Matkas\ChildMatka\Id;
use App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatkaRepository;
use App\Model\Paseka\Entity\Uchasties\Uchastie\UchastieRepository;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Id as UchastieId;


class Handler
{
    private $uchasties;
    private $childmatkas;
    private $flusher;

    public function __construct(UchastieRepository $uchasties, ChildMatkaRepository $childmatkas, Flusher $flusher)
    {
        $this->uchasties = $uchasties;
        $this->childmatkas = $childmatkas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $actor = $this->uchasties->get(new UchastieId($command->actor));
        $childmatka = $this->childmatkas->get(new Id($command->id));

        if ($command->parent) {
            $parent = $this->childmatkas->get(new Id($command->parent));
            $childmatka->setChildOf($actor, new \DateTimeImmutable(), $parent);

        } else {
            $childmatka->setRoot();
        }

        $this->flusher->flush();
    }
}

