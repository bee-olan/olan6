<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\ChildMatka\Files\Add;

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
     * @var File[]
     */
    public $files;

    public function __construct(int $id, string $actor )
    {
        $this->id = $id;
        $this->actor = $actor;
    }
}
