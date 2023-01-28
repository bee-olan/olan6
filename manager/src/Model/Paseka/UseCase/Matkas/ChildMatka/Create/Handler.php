<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\ChildMatka\Create;

use App\Model\Flusher;
use App\Model\Mesto\Entity\InfaMesto\MestoNomerRepository;
use App\Model\Mesto\Entity\InfaMesto\Id as MestoNomerId;
use App\Model\Paseka\Entity\Uchasties\Personas\PersonaRepository;
use App\Model\Paseka\Entity\Uchasties\Personas\Id as PersonaId;

use App\Model\Paseka\Entity\Uchasties\Uchastie\Id as UchastieId;
use App\Model\Paseka\Entity\Uchasties\Uchastie\UchastieRepository;

use App\Model\Paseka\Entity\Matkas\Sparings\SparingRepository;
use App\Model\Paseka\Entity\Matkas\Sparings\Id as SparingId;

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
    private $sparings;
    private $personas;
    private $mestonomers;
    private $flusher;

    public function __construct(
            UchastieRepository $uchasties, 
            PlemMatkaRepository $plemmatkas, 
            ChildMatkaRepository $childmatkas,
            SparingRepository $sparings,
            PersonaRepository $personas,
            MestoNomerRepository $mestonomers,
            Flusher $flusher)
    {
        $this->uchasties = $uchasties;
        $this->plemmatkas = $plemmatkas;
        $this->childmatkas = $childmatkas;
        $this->sparings = $sparings;
        $this->personas=$personas;
        $this->mestonomers=$mestonomers;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        for ($i = 1; $i <= 3; $i++) {

        $uchastie = $this->uchasties->get(new UchastieId($command->uchastie));

        $persona = $this->personas->get(new PersonaId($command->uchastie));

        $mestonomer = $this->mestonomers->get(new MestoNomerId($command->uchastie));

        $plemmatka = $this->plemmatkas->get(new PlemMatkaId($command->plemmatka));

        $sparing = $this->sparings->get(new SparingId($command->sparing));
        $command->godaVixod = (int)$command->plan_date->format('Y');
        $childmatkaId = $this->childmatkas->nextId();
//        $command->name =  ($plemmatka->getName())."_".$childmatkaId;
$command->name = $plemmatka->getNameKateg()."_".$plemmatka->getSort()."-".$childmatkaId." : пн-".
    $persona->getNomer()."_".$mestonomer->getNomer()."_".$command->godaVixod."_".$childmatkaId ;

//        $date = new \DateTimeImmutable();


        $childmatka = new ChildMatka(
            $childmatkaId,
            $plemmatka,
            $uchastie,
            $command->plan_date,
            new Type($command->type),
            $command->priority,
            $command->name,
            $command->content,
            $sparing,
            $command->godaVixod

        );

        if ($command->parent) {
            $parent = $this->childmatkas->get(new Id($command->parent));
            $childmatka->setChildOf($parent);
        }

//        if ($command->plan) {
//            $childmatka->plan($uchastie, $date, $command->plan);
//        }

        $this->childmatkas->add($childmatka);
    }
        $this->flusher->flush();
    }
}
