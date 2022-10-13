<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Rasas\Linias\Nomers\Remove;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $linia;
    /**
     * @Assert\NotBlank()
     */
    public $id;

    public function __construct(string $linia, string $id)
    {
        $this->linia = $linia;
        $this->id = $id;
    }
}

