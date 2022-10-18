<?php

declare(strict_types=1);

namespace App\Model\Sait\UseCase\U4astniks\Personas\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
	 * @var int
     * @Assert\NotBlank()
     */
    public $nomer;

   // /**
   //  * @Assert\NotBlank()
   //  */
   // public $u4astnik;

   // public function __construct( string $u4astnik)
   // {
    //    $this->u4astnik = $u4astnik;
   // }

}