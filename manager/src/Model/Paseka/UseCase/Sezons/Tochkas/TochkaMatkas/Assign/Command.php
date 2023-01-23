<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Tochkas\TochkaMatkas\Assign;

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
    public $childmatka;

    /**
     * @Assert\NotBlank()
     */
    public $uchastie;


    public function __construct(string $tochka
//        , string $childmatka

                                )
    {
        $this->tochka = $tochka;
//        $this->childmatka = $childmatka;
    }
}