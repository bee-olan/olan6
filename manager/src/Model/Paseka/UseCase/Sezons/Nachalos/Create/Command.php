<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Nachalos\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $id;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $goda;


    /**
     * @var int
     */
    public $koltochek;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $gruppa;
//string $id,
    public function __construct( string $gruppa)
    {
//        $this->id = $id;
//        $this->gruppa = $gruppa;
        $this->goda = 2015;
    }
}