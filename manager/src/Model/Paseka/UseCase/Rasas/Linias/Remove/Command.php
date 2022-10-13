<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Rasas\Linias\Remove;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $rasa;
    /**
     * @Assert\NotBlank()
     */
    public $id;

    public function __construct(string $rasa, string $id)
    {
        $this->rasa = $rasa;
        $this->id = $id;
    }
}

