<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Nachalos\Create\Edit;

//use App\Model\Paseka\Entity\Rasas\Rasa;
use App\Model\Sezons\Entity\Sxemas\Sxema;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $id;
//
//    /**
//     * @var string
//     * @Assert\NotBlank()
//     */
//    public $sezon;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $uchastie;

    /**
     * @var string
     */
    public $content;


    /**
     * @var int
     */
    public $kolwz;

    /**
     * @var int
     */
    public $gruppa;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

   public static function fromSxema(Sxema $sxema): self
    {
       $command = new self($sxema->getId()->getValue());
       $command->kolwz = $sxema->getKolwz();
       $command->content = $sxema->getContent();
       return $command;
    }
}
