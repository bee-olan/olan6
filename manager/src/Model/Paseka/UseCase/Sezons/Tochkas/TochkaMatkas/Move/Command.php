<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Tochkas\TochkaMatkas\Move;

use App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatka;
use Symfony\Component\Validator\Constraints as Assert;
class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $id; // TestMat
    /**
     * @Assert\NotBlank()
     */
    public $tochka;  //точек куда переместить

//    /**
//     * @Assert\Type("bool")
//     */
//    public $withChildren; // перемещение с дочерними или нет - не нужно

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public static function fromChildMatka(ChildMatka $childMatka): self
    {
        $command = new self($childMatka->getId()->getValue());
        $command->tochka = $childMatka->getProject()->getId()->getValue();
        return $command;
    }
}



