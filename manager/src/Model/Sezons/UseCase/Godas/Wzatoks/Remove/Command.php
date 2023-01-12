<?php

declare(strict_types=1);

namespace App\Model\Sezons\UseCase\Godas\Wzatoks\Remove;

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
