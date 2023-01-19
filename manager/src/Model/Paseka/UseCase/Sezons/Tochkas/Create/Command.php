<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Tochkas\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $uchasgoda;

    /**
     * @var int
     */
    public $kolwz;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $gruppa;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $name;

    public function __construct(string $uchasgoda,
                                string $gruppa
                                )
    {
        $this->uchasgoda = $uchasgoda;
        $this->gruppa = $gruppa;
    }
}