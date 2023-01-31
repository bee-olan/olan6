<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\PlemMatka\Uchastnik\Add;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $plemmatka;

//    /**
//     * @Assert\NotBlank()
//     */
//    public $uchastie;

    /**
     * @Assert\NotBlank()
     */
    public $departments;
    /**
     * @Assert\NotBlank()
     */
    public $roles;

    public function __construct(string $plemmatka)
    {
        $this->plemmatka = $plemmatka;
    }
}
