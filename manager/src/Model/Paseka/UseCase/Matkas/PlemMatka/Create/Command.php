<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\PlemMatka\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
//    /**
//     * @Assert\NotBlank()
//     */
//    public $name;

    /**
     * @Assert\NotBlank()
     */
    public $sort;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $uchastieId;

//    /**
//     * @var string
//     * @Assert\NotBlank()
//     */
//    public $rasaNomId;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $title;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $nomerId;

//    /**
//     * @Assert\NotBlank()
//     */
//    public $persona;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $goda;

    /**
     * @Assert\NotBlank()
     */
    public $kategoria;

    public function __construct(string $nomerId, int $sort, string $uchastieId)
    {
        $this->nomerId=$nomerId;
        $this->sort = $sort;
        $this->uchastieId = $uchastieId;

    }
}
