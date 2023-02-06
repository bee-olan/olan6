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
    public $actor;

    /**
     * @Assert\NotBlank()
     */
    public $id;
    /**
     * @Assert\NotBlank()
     */
    public $priority;

    public function __construct(string $actor, int $id)
    {
        $this->actor = $actor;
        $this->id = $id;
    }

    public static function fromChildMatka(string $actor, ChildMatka $childmatka): self
    {
        $command = new self($actor, $childmatka->getId()->getValue());
        $command->priority = $childmatka->getPriority();
        return $command;
    }
}


