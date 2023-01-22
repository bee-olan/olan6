<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Tochkas\Wzatoks\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $tochka;


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


    /**
     * @var int
     */
    public $rasstojan;

    /**
     * @var int
     */
    public $nomerwz;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $gruppa;

    /**
     * @var int
     */
    public $rabotach;

    /**
     * @var int
     */
    public $rabotad;

    public function __construct(string $tochka,
                                string $gruppa,
                                int $nomerwz
                                )
    {
        $this->tochka = $tochka;
        $this->gruppa = $gruppa;
        $this->nomerwz = $nomerwz;
    }
}