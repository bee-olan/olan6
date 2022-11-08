<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\ChildMatka\ChildOf;

use App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatka;
use App\Model\Work\Entity\Projects\Task\Task;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $id;

    public $parent;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public static function fromChildMatka(ChildMatka $childmatka): self
    {
        $command = new self($childmatka->getId()->getValue());
        $command->parent = $childmatka->getParent() ? $childmatka->getParent()->getId()->getValue() : null;
        return $command;
    }
}