<?php

declare(strict_types=1);
namespace App\Model\Paseka\UseCase\Sezons\Tochkas\TochkaMatkas\Move;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatkaRepository;
use App\Model\Paseka\Entity\Matkas\ChildMatka\Id;

use App\Model\Paseka\Entity\Sezons\Tochkas\TochkaRepository;
use App\Model\Paseka\Entity\Sezons\Tochkas\Id as TochkaId;

class Handler
{
    private $tasks;
    private $flusher;
    private $tochkas;

    public function __construct(
        ChildMatkaRepository $childmatkas,
        TochkaRepository $tochkas,
        Flusher $flusher
    )
    {
        $this->childmatkas = $childmatkas;
        $this->flusher = $flusher;
        $this->tochkas = $tochkas;
    }

    public function handle(Command $command): void
    {
        $childmatka = $this->childmatkas->get(new Id($command->id)); // берем матку
        $tochka = $this->tochkas->get(new TochkaId($command->tochka));// достаем точку

        $childmatka->move($tochka); // вызываем move

//        if ($command->withChildren) {
//            $children = $this->childmatkas->allByParent($childmatka->getId());
//            foreach ($children as $child) {
//                $child->move($tochka);
//            }
//        }

        $this->flusher->flush();
    }

}



