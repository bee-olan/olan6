<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\ChildMatka\Create;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Id as UchastieId;
use App\Model\Paseka\Entity\Uchasties\Uchastie\UchastieRepository;

use App\Model\Paseka\Entity\Matkas\PlemMatka\Id as PlemMatkaId;
use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatkaRepository;

use App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatka;
use App\Model\Paseka\Entity\Matkas\ChildMatka\Id;
use App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatkaRepository;
use App\Model\Paseka\Entity\Matkas\ChildMatka\Type;


class Handler
{
    private $uchasties;
    private $plemmatkas;
    private $childmatkas;
    private $flusher;

    public function __construct(UchastieRepository $uchasties, PlemMatkaRepository $plemmatkas, ChildMatkaRepository $childmatkas, Flusher $flusher)
    {
        $this->uchasties = $uchasties;
        $this->plemmatkas = $plemmatkas;
        $this->childmatkas = $childmatkas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {

        $uchastie = $this->uchasties->get(new UchastieId($command->uchastie));
        $plemmatka = $this->plemmatkas->get(new PlemMatkaId($command->plemmatka));

        $childmatkaId = $this->childmatkas->nextId();
        $command->name =  ($plemmatka->getName())."_".$childmatkaId;

        $childmatka = new ChildMatka(
            $childmatkaId,
            $plemmatka,
            $uchastie,
            new \DateTimeImmutable(),
            new Type($command->type),
            $command->priority,
            $command->name,
            $command->content
        );

        if ($command->parent) {
            $parent = $this->childmatkas->get(new Id($command->parent));
            $childmatka->setChildOf($parent);
        }

        if ($command->plan) {
            $childmatka->plan($command->plan);
        }

        $this->childmatkas->add($childmatka);

        $this->flusher->flush();
    }
}