<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\ChildMatka\TakeAndStart;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $id;
    /**
     * @Assert\NotBlank()
     */
    public $actor;

    public function __construct(string $actor, int $id)
    {
        $this->id = $id;
        $this->actor = $actor;
    }
}

