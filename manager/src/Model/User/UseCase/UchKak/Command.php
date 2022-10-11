<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\UchKak;

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
    public $uchkak;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
}
