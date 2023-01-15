<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Nachalos\Create;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Sezons\Nachalos\Nachalo;
use App\Model\Paseka\Entity\Sezons\Nachalos\NachaloRepository;
use App\Model\Paseka\Entity\Sezons\Nachalos\Id;

use App\Model\Sezons\Entity\Godas\GodaRepository;
use App\Model\Sezons\Entity\Godas\Id as GodaId;



class Handler
{
    private $godas;
    private $nachalos;
    private $flusher;

    public function __construct(NachaloRepository $nachalos, GodaRepository $godas, Flusher $flusher)
    {
        $this->nachalos = $nachalos;
        $this->godas = $godas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
//        $id = new Id($command->id);

//        if ($this->nachalos->has($id)) {
//            throw new \DomainException('Вы уже участник в этом году существует !!.');
//        }

        $goda = $this->godas->get(new GodaId($command->goda));
//        $group = $this->groups->get(new GroupId($command->group));
//        $command->gruppa ;
//            =  $command->gruppa."-".$goda->getGod();
dd($command->goda=$goda);
        $nachalo = new Nachalo(
            Id::next(),
            $command->goda,
            $command->koltochek,
            $command->gruppa
                );

        $this->nachalos->add($nachalo);

        $this->flusher->flush();
    }
}
