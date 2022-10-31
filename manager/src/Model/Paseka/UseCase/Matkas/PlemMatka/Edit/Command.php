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
     * @var string
     * @Assert\NotBlank()
     */
    public $title;



    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromPlemMatka(PlemMatka $plemmatka): self
    {
        $command = new self($plemmatka->getId()->getValue());
        $command->title = $plemmatka->getTitle();

        return $command;
    }
}
