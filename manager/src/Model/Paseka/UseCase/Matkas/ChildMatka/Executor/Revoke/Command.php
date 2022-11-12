<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\ChildMatka\Executor\Revoke;

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
    /**
     * @Assert\NotBlank()
     */
    public $uchastie;

    public function __construct(string $actor, int $id, string $uchastie)
    {
        $this->actor = $actor;
        $this->id = $id;
        $this->uchastie = $uchastie;
    }
}
