<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\ChildMatka\Edit;

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
//
//    /**
//     * @Assert\NotBlank()
//     */
//    public $name;

    public $content;

    public function __construct(string $actor, int $id)
    {
        $this->actor = $actor;
        $this->id = $id;
    }

    public static function fromChildMatka(string $actor, ChildMatka $childmatka): self
    {
        $command = new self($actor, $childmatka->getId()->getValue());

        $command->content = $childmatka->getContent();
        return $command;
    }
}
