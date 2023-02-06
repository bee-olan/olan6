<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\ChildMatka\Files\Remove;

use App\Model\Flusher;
//use App\Model\Work\Entity\Uchasties\Member\Id as MemberId;
//use App\Model\Work\Entity\Members\Member\MemberRepository;
//use App\Model\Work\Entity\Projects\ChildMatka\Id;
//use App\Model\Work\Entity\Projects\ChildMatka\ChildMatkaRepository;
//use App\Model\Work\Entity\Projects\ChildMatka\File\Id as FileId;

use App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatkaRepository;
use App\Model\Paseka\Entity\Matkas\ChildMatka\Id;
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

        $childmatka->removeFile($actor, new \DateTimeImmutable(), new FileId($command->file));

        $this->flusher->flush();
    }
}

