<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\PlemMatka\Edit;

use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatka;

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
    public $name;
    /**
     * @Assert\NotBlank()
     */
    public $sort;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromPlemMatka(PlemMatka $plemmatka): self
    {
        $command = new self($plemmatka->getId()->getValue());
        $command->name = $plemmatka->getName();
        $command->sort = $plemmatka->getSort();
        return $command;
    }
}
