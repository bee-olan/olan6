<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Godas\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
//    /**
//     * @var string
//     * @Assert\NotBlank()
//     */
//    public $id;

    /**
     * @var int
     * @Assert\NotBlank()
     */
    public $god;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $sezon;

    public function __construct(int $god)
    {
        $this->god = $god;
    }

}