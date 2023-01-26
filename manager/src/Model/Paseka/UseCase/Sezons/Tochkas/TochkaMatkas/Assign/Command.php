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
     * @var array
     * @Assert\NotBlank()
     */
    public $childmatkas;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $gruppa;


    public function __construct(string $tochka, string $gruppa )
    {
        $this->tochka = $tochka;
        $this->gruppa = $gruppa;
    }
}