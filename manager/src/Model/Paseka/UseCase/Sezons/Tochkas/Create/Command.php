<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Tochkas\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $goda;

//    /**
//     * @var string
//     * @Assert\NotBlank()
//     */
//    public $uchastieId;

    /**
     * @var string
     */
    public $content;


    /**
     * @var int
     */
    public $kolwz;

//    /**
//     * @var int
//     */
//    public $koltochek;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $gruppa;

    public function __construct(string $goda,
                                string $gruppa
                                )
    {
        $this->goda = $goda;
        $this->gruppa = $gruppa;

    }
}