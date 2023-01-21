<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Tochkas\Wzatoks\Edit;

//use App\Model\Paseka\Entity\Rasas\Rasa;
use App\Model\Paseka\Entity\Sezons\Tochkas\Tochka;
use App\Model\Paseka\Entity\Sezons\Tochkas\Wzatoks\Wzatok;
use App\Model\Sezons\Entity\Sxemas\Sxema;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $tochka;

    /**
     * @Assert\NotBlank()
     */
    public $id;

    /**
     * @var \DateTimeImmutable
     * @Assert\Date()
     */
    public $start_date;


    /**
     * @var \DateTimeImmutable
     * @Assert\Date()
     */
    public $pobelka_date;

    /**
     * @var \DateTimeImmutable
     * @Assert\Date()
     */
    public $end_date;

//
//    /**
//     * @var int
//     */
//    public $rasstojan;

//    /**
//     * @var int
//     */
//    public $nomerwz;

//    /**
//     * @var string
//     * @Assert\NotBlank()
//     */
//    public $gruppa;

    public function __construct(string $tochka , string $id)
    {
        $this-> tochka= $tochka;
        $this->id = $id;
    }

   public static function fromWzatok(Tochka $tochka, Wzatok $wzatok): self
    {
       $command = new self($tochka->getId()->getValue(), $wzatok->getId()->getValue());
       $command->start_date= $wzatok->getStartDate();
       $command->pobelka_date = $wzatok->getPobelkaDate();
       $command->end_date = $wzatok->getEndDate();
       return $command;
    }
}
