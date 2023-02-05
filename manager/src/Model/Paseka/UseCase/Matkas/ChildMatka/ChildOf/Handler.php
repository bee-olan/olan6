<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\ChildMatka\ChildOf;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Matkas\ChildMatka\Id;
use App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatkaRepository;

class Handler
{
    private $childmatkas;
    private $flusher;

    public function __construct(ChildMatkaRepository $childmatkas, Flusher $flusher)
    {
        $this->childmatkas = $childmatkas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $childmatka = $this->childmatkas->get(new Id($command->id));

        if ($command->parent) {
            $parent = $this->childmatkas->get(new Id($command->parent));
            $childmatka->setChildOf($parent);
        } else {
            $childmatka->setRoot();
        }

        $this->flusher->flush();
    }
}

