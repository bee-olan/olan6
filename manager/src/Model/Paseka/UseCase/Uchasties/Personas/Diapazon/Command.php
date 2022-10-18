<?php

declare(strict_types=1);

namespace App\Model\Sait\UseCase\U4astniks\Personas\Diapazon;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
	 * @var int
     * @Assert\NotBlank()
     */
    public $diapazon;


}