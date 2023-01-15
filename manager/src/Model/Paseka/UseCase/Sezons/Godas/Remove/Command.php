<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Godas\Remove;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}