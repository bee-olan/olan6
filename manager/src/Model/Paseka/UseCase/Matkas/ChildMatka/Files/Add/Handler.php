<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\ChildMatka\Files\Add;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatkaRepository;
use App\Model\Paseka\Entity\Matkas\ChildMatka\Id;
use App\Model\Paseka\Entity\Matkas\ChildMatka\File\Info;

use App\Model\Paseka\Entity\Uchasties\Uchastie\UchastieRepository;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Id as UchastieId;

use App\Model\Paseka\Entity\Matkas\ChildMatka\File\Id as FileId;


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

        foreach ($command->files as $file) {
            $childmatka->addFile(
                $actor, new \DateTimeImmutable(),
                FileId::next(),
                new Info(
                    $file->path,
                    $file->name,
                    $file->size
                )
            );
        }

        $this->flusher->flush();
    }
}

