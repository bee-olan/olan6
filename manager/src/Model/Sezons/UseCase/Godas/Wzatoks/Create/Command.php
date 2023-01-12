<?php

declare(strict_types=1);

namespace App\Model\Sezons\UseCase\Godas\Wzatoks\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $goda;
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

    public function __construct(string $goda,
                                string $uchastie,
                                int $gruppa
                                )
    {
        $this->goda = $goda;
        $this->uchastie = $uchastie;
        $this->gruppa = $gruppa;
        $this->content = $goda."-".$gruppa;
    }
}