<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\ChildMatka\Move;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Matkas\ChildMatka\Id;
use App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatkaRepository;
use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatkaRepository;
use App\Model\Paseka\Entity\Matkas\PlemMatka\Id as PlemMatkaId;

class Handler
{
    private $childmatkas;
    private $flusher;
    private $plemmatkas;

    public function __construct(
        ChildMatkaRepository $childmatkas,
        PlemMatkaRepository $plemmatkas,
        Flusher $flusher
    )
    {
        $this->childmatkas = $childmatkas;
        $this->flusher = $flusher;
        $this->plemmatkas = $plemmatkas;
    }

    public function handle(Command $command): void
    {
        $childmatka = $this->childmatkas->get(new Id($command->id));
        $plemmatka = $this->plemmatkas->get(new PlemMatkaId($command->plemmatka));

        $childmatka->move($plemmatka);

        if ($command->withChildren) {
            $children = $this->childmatkas->allByParent($childmatka->getId());
            foreach ($children as $child) {
                $child->move($plemmatka);
            }
        }

        $this->flusher->flush();
    }
}

