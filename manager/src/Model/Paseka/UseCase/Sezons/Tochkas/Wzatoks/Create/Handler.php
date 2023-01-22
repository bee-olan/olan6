<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Tochkas\Wzatoks\Create;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Sezons\Tochkas\TochkaRepository;
use App\Model\Paseka\Entity\Sezons\Tochkas\Id as TochkaId;
use App\Model\Paseka\Entity\Sezons\Tochkas\Wzatoks\Id;

use DateTimeImmutable;


class Handler
{
    private $tochkas;
    private $flusher;

    public function __construct(TochkaRepository $tochkas, Flusher $flusher)
    {
        $this->tochkas = $tochkas;
        $this->flusher = $flusher;
//        public DateTimeInterface::format(string $format): string;
    }

    public function handle(Command $command): void
    {
        $tochka = $this->tochkas->get(new TochkaId($command->tochka));

        $pobelkaDate = $command->pobelka_date;
        $startDate = $command->start_date;
        $endDate = $command->end_date;

        $shirota= 47.6853247;
        $dolgot= 41.82589;

        $si = date_sun_info(strtotime($startDate->format('Y-m-d')), $shirota , $dolgot);
        $diffstart = $si['sunset'] - $si['sunrise'];

        $si = date_sun_info(strtotime($endDate->format('Y-m-d')), $shirota , $dolgot);
        $diffend = $si['sunset'] - $si['sunrise'];

        $diffSR = ($diffstart + $diffend )/2;

        $start = strtotime($startDate->format('Y-m-d')); // какая-то дата в строке (1 января 2017 года)
        $end = strtotime($endDate->format('Y-m-d'));
        $datediff = $end - $start; // получим разность дат (в секундах)

        $rabotad = floor($datediff / (60 * 60 * 24));
        $rabotach = floor($diffSR*$rabotad/3600);

        $tochka->addWzatok(
            Id::next(),
            $command->rasstojan,
            $startDate,
            $command->pobelka_date,
            $endDate,
            $command->nomerwz,
            $command->gruppa,
            (int)$rabotad,
            (int)$rabotach
                );

//dd($endDate->format('Y-m-d'));

//

//

//        echo "Продолжительность дня: ",
//        floor($diffstart / 3600), " ч. ",
//        floor(($diffstart % 3600) / 60), " сек.\n";





//    dd($chasow);


        $this->flusher->flush();
    }
}
