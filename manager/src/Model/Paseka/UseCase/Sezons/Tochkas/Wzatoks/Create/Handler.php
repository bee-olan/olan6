<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Tochkas\Wzatoks\Create;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Sezons\Tochkas\TochkaRepository;
use App\Model\Paseka\Entity\Sezons\Tochkas\Id as TochkaId;
use App\Model\Paseka\Entity\Sezons\Tochkas\Wzatoks\Id;


class Handler
{
    private $tochkas;
    private $flusher;

    public function __construct(TochkaRepository $tochkas, Flusher $flusher)
    {
        $this->tochkas = $tochkas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $tochka = $this->tochkas->get(new TochkaId($command->tochka));

//        $command->gruppa =  $command->gruppa."-".$tochka->getGod();

        $pobelkaDate = $command->pobelka_date;
        $startDate = $command->start_date;
        $endDate = $command->end_date;
//        $date = new \DateTimeImmutable();

        $tochka->addWzatok(
            Id::next(),
            $command->rasstojan,
            $startDate,
            $command->pobelka_date,
            $endDate,
            $command->nomerwz,
            $command->gruppa
                );

        $this->flusher->flush();
    }
}
