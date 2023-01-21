<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Tochkas\Wzatoks\Create;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Sezons\Tochkas\TochkaRepository;
use App\Model\Paseka\Entity\Sezons\Tochkas\Id as TochkaId;
use App\Model\Paseka\Entity\Sezons\Tochkas\Wzatoks\Id;
use DateTime;


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
//        $shirota =  47.6853247;
//        $dolgot=41.82589519999999;


//

//        $di = explode(" ", $endDate);
//        dd($di[0]);
//        dd( new DateTime($endDate) );
//        $theDate    = new DateTime($endDate);
//
//        dd( $theDate->format('Y-m-d H:i:s'));
//        $theDate ->format('Y-m-d H:i:s');
//        dd($theDate ->format('Y-m-d H:i:s') );
//
//        $si = date_sun_info(strtotime('2018-05-12'), $shirota , $dolgot);
//        $diffstart = $si['sunset'] - $si['sunrise'];
//
//        $si = date_sun_info(strtotime('2018-05-24'), $shirota , $dolgot);
//        $diffend = $si['sunset'] - $si['sunrise'];
//
//        echo "Продолжительность дня: ",
//        floor($diffstart / 3600), " ч. ",
//        floor(($diffstart % 3600) / 60), " сек.\n";
//       $diffSR = ($diffstart + $diffend )/2;
//
//        $start = strtotime("2018-05-12"); // какая-то дата в строке (1 января 2017 года)
//        $end = strtotime("2018-05-24");
//        $datediff = $end - $start; // получим разность дат (в секундах)
//
//        $dni = floor($datediff / (60 * 60 * 24));
//        $chasow = floor($diffSR*$dni/3600);
//
//
//    dd($chasow);


        $this->flusher->flush();
    }
}
