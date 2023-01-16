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



    public function __construct(string $goda, string $uchastie)
    {
        $this->goda = $goda;
        $this->uchastie = $uchastie;
    }
}