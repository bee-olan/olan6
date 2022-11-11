<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\ChildMatka\Take;

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
    public $uchaste;

    public function __construct(string $uchaste,int $id )
    {
        $this->id = $id;
        $this->uchaste = $uchaste;
    }
}
