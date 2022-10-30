<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\PlemMatka\Create;

use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $name;

    /**
     * @Assert\NotBlank()
     */
    public $sort;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $uchastieId;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $rasaNomId;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $mesto;

    /**
     * @Assert\NotBlank()
     */
    public $persona;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $sparing;
}
