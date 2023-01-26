<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Tochkas\TochkaMatkas\Assign;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Matkas\ChildMatka\Id as ChildMatkaId;
use App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatkaRepository;
use App\Model\Paseka\Entity\Sezons\Tochkas\TochkaRepository;
use App\Model\Paseka\Entity\Sezons\Tochkas\Id ;


use DateTimeImmutable;


class Handler
{
    private $tochkas;
    private $childmatkass;
    private $flusher;

    public function __construct(TochkaRepository $tochkas, ChildMatkaRepository $childmatkass, Flusher $flusher)
    {
        $this->tochkas = $tochkas;
        $this->childmatkass = $childmatkass;
        $this->flusher = $flusher;
//        public DateTimeInterface::format(string $format): string;
    }

    public function handle(Command $command): void
    {
//$childmatka = $this->childmatkas->get(new ChildMatkaId($command->childmatka));
//dd($command->childmatkas);
        $tochka = $this->tochkas->get(new Id($command->tochka));

        foreach ($command->childmatkas as $id) {
            $childmatka = $this->childmatkass->get(new ChildMatkaId($id));
            $tochka->addChildMatka($childmatka, $command->gruppa);
//            if (!$tochka->hasExecutor($childmatka->getId())) {
//                $tochka->assignExecutor($uchastie, new \DateTimeImmutable(), $childmatka);
//            }
        }

        $this->flusher->flush($tochka);
    }

}





