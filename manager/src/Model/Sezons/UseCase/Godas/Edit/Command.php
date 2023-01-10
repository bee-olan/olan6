<?php

declare(strict_types=1);

namespace App\Model\Sezons\UseCase\Godas\Edit;


use App\Model\Sezons\Entity\Godas\Goda;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $id;

    /**
     * @var int
     * @Assert\NotBlank()
     */
    public $god;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $sezon;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

   public static function fromGoda(Goda $goda): self
    {
       $command = new self($goda->getId()->getValue());
       $command->god = $goda->getGod;
       $command->sezon = $goda->getSezon();
       return $command;
    }
}
