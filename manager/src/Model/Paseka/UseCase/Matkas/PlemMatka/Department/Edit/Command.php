<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\PlemMatka\Department\Edit;

use App\Model\Paseka\Entity\Matkas\PlemMatka\Department\Department;
use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatka;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $plemmatka;
    /**
     * @Assert\NotBlank()
     */
    public $id;
    /**
     * @Assert\NotBlank()
     */
    public $name;

    public function __construct(string $plemmatka, string $id)
    {
        $this->plemmatka = $plemmatka;
        $this->id = $id;
    }

    public static function fromDepartment(PlemMatka $plemmatka, Department $department): self
    {
        $command = new self($plemmatka->getId()->getValue(), $department->getId()->getValue());
        $command->name = $department->getName();
        return $command;
    }
}
