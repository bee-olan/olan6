<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\ChildMatka\Move;

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
    public $plemmatka;
    /**
     * @Assert\Type("bool")
     */
    public $withChildren;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public static function fromTask(ChildMatka $childmatka): self
    {
        $command = new self($childmatka->getId()->getValue());
        $command->plemmatka = $childmatka->getPlemMatka()->getId()->getValue();
        return $command;
    }
}
