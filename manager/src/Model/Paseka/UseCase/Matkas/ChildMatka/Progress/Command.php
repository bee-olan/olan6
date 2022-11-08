<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\ChildMatka\Progress;

use App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatka;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $id;
    /**
     * @Assert\NotBlank()
     */
    public $progress;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public static function fromTask(ChildMatka $childmatka): self
    {
        $command = new self($childmatka->getId()->getValue());
        $command->progress = $childmatka->getProgress();
        return $command;
    }
}



