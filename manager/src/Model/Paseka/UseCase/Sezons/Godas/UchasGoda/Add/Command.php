<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Godas\UchasGoda\Add;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $goda;

    /**
     * @Assert\NotBlank()
     */
    public $uchastie;

    /**
     * @var int
     */
    public $koltochek;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $gruppa;

    public function __construct(string $goda, string $uchastie, string $gruppa)
    {
        $this->goda = $goda;
        $this->uchastie = $uchastie;
        $this->gruppa = $gruppa;

    }
}