<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\ChildMatka\Priority;

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
    public $priority;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public static function fromChildMatka(ChildMatka $childmatka): self
    {
        $command = new self($childmatka->getId()->getValue());
        $command->priority = $childmatka->getPriority();
        return $command;
    }
}


