<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Tochkas\TochkaMatkas\Edit;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Sezons\Tochkas\TochkaRepository;
use App\Model\Paseka\Entity\Sezons\Tochkas\Id;
use App\Model\Paseka\Entity\Sezons\Tochkas\Wzatoks\Id as WzatokId;

//use App\Model\Paseka\Entity\Sxemas\Id;
//use App\Model\Paseka\Entity\Sxemas\SxemaRepository;

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
        $tochka = $this->tochkas->get(new Id($command->tochka));

        $tochka->editWzaDate(new WzatokId($command->id),
                        $command->start_date, $command->pobelka_date,
                        $command->end_date);

        $this->flusher->flush();
    }
}
