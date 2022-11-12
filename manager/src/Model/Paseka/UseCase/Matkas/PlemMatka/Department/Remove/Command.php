<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\PlemMatka\Department\Remove;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $plemmatka;
    /**
     * @Assert\NotBlank()
     */
    public $id;

    public function __construct(string $plemmatka, string $id)
    {
        $this->plemmatka = $plemmatka;
        $this->id = $id;
    }
}

