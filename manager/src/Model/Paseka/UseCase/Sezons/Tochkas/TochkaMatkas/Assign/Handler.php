<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Tochkas\TochkaMatkas\Assign;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Matkas\ChildMatka\Id as ChildMatkaId;
use App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatkaRepository;
use App\Model\Paseka\Entity\Sezons\Tochkas\TochkaRepository;
use App\Model\Paseka\Entity\Sezons\Tochkas\Id as TochkaId;


use DateTimeImmutable;


class Handler
{
    private $tochkas;
    private $childmatkas;
    private $flusher;

    public function __construct(TochkaRepository $tochkas, ChildMatkaRepository $childmatkas, Flusher $flusher)
    {
        $this->tochkas = $tochkas;
        $this->childmatkas = $childmatkas;
        $this->flusher = $flusher;
//        public DateTimeInterface::format(string $format): string;
    }

    public function handle(Command $command): void
    {
        dd($command->tochka);
        $tochka = $this->tochkas->get(new TochkaId($command->tochka));
//        $childmatka = $this->childmatkas->get(new ChildMatkaId($command->childmatka));


//        $tochka->addWzatok($childmatka);



        $this->flusher->flush();
    }
}
