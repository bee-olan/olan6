<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\ChildMatka\Take;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $actor;
    /**
     * @Assert\NotBlank()
     */
    public $id;

    public function __construct(string $actor, int $id)
    {
        $this->id = $id;
        $this->actor = $actor;
    }
}
