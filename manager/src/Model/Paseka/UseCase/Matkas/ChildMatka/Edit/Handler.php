<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\ChildMatka\Edit;

use App\Model\Flusher;

use App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatkaRepository;
use App\Model\Paseka\Entity\Matkas\ChildMatka\Id;

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

        $childmatka->edit(
            $command->name,
            $command->content
        );

        $this->flusher->flush();
    }
}


