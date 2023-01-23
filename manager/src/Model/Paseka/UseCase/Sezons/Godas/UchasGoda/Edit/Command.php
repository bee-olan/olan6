<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Godas\UchasGoda\Edit;


use App\Model\Paseka\Entity\Sezons\Godas\UchasGoda;
use App\Model\Paseka\Entity\Sezons\Godas\Id;
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
     */
    public $koltochek;



    public function __construct(string $id)
    {
        $this->id = $id;
    }

   public static function fromUchasGoda(string $uchasgoda): self
    {
       $command = new self($uchasgoda);

       $command->koltochek = $uchasgoda->getKoltochek();

       return $command;
    }
}
