<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\ChildMatka\Move;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Matkas\ChildMatka\Id;
use App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatkaRepository;
use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatkaRepository;
use App\Model\Paseka\Entity\Matkas\PlemMatka\Id as PlemMatkaId;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Id as UchastieId;
use App\Model\Paseka\Entity\Uchasties\Uchastie\UchastieRepository;

class Handler
{
    private $uchasties;
    private $childmatkas;
    private $flusher;
    private $plemmatkas;

    public function __construct(
        UchastieRepository $uchasties,
        ChildMatkaRepository $childmatkas,
        PlemMatkaRepository $plemmatkas,
        Flusher $flusher
    )
    {
        $this->uchasties = $uchasties;
        $this->childmatkas = $childmatkas;
        $this->flusher = $flusher;
        $this->plemmatkas = $plemmatkas;
    }

    public function handle(Command $command): void
    {
        $actor = $this->uchasties->get(new UchastieId($command->actor));
        $childmatka = $this->childmatkas->get(new Id($command->id));
        $plemmatka = $this->plemmatkas->get(new PlemMatkaId($command->plemmatka));

        $childmatka->move($actor, new \DateTimeImmutable(), $plemmatka);

        if ($command->withChildren) {
            $children = $this->childmatkas->allByParent($childmatka->getId());
            foreach ($children as $child) {
                $child->move($actor, new \DateTimeImmutable(), $plemmatka);
            }
        }

        $this->flusher->flush();
    }
}

