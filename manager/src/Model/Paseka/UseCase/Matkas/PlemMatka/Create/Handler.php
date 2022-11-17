<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\PlemMatka\Create;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatka;
use App\Model\Paseka\Entity\Matkas\PlemMatka\Id;
use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatkaRepository;
use App\Model\Paseka\Entity\Matkas\Sparings\Sparing;
use App\Model\Paseka\Entity\Matkas\Sparings\SparingRepository;
use App\Model\Paseka\Entity\Matkas\Sparings\Id as SparingId;

use App\Model\Paseka\Entity\Matkas\Kategoria\KategoriaRepository;
use App\Model\Paseka\Entity\Matkas\Kategoria\Id as KategoriaId;

class Handler
{
    private $plemmatkas;
   // private $sparings;
    private $kategorias;
    private $flusher;

    public function __construct(PlemMatkaRepository $plemmatkas,
//                                SparingRepository $sparings,
                                KategoriaRepository $kategorias,
                                Flusher $flusher)
    {
        $this->plemmatkas = $plemmatkas;
//        $this->sparings = $sparings;
        $this->kategorias = $kategorias;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        //$sparing = $this->sparings->get(new SparingId($command->sparing));
        $kategoria = $this->kategorias->get(new KategoriaId($command->kategoria));

//dd($kategoria->getName());
//        if ($this->plemmatkas->hasBySort($command->sort)) {
//            throw new \DomainException('ТАКОЙ номер есть в БД.');
//        }

        if ($this->plemmatkas->hasSortPerson($command->sort, $command->persona)) {
            throw new \DomainException('ТАКОЙ номер есть в БД.');
        }

        $plemmatka = new PlemMatka(
            Id::next(),
            $command->name ,
            $command->sort,
//            $sparing,
            $command->uchastieId,
            $command->mesto,
            $command->persona,
            $command->rasaNomId,
            $command->title,
            $command->nameKateg = $kategoria->getName(),
            $kategoria

        );

        $this->plemmatkas->add($plemmatka);

        $this->flusher->flush();
    }
}
