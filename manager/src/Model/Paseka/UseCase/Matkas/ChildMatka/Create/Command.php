<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\ChildMatka\Create;

use App\Model\Paseka\Entity\Matkas\ChildMatka\Type;
// use App\Model\Work\Entity\Projects\Task\Type;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $plemmatka;
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $uchastie;
    /**
     * @Assert\NotBlank()
     */
    public $name;
    /**
     * @var string
     */
    public $content;
    /**
     * @var int
     */
    public $parent;

    /**
     * @var \DateTimeImmutable
     * @Assert\Date()
     */
    public $plan_date;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $type;

    /**
     * @Assert\NotBlank()
     */
    public $priority;

    /**
     * @Assert\NotBlank()
     */
    public $sparing;

//    /**
//     * @var string
//     * @Assert\NotBlank()
//     */
//    public $goda;

//    /**
//     * @var int
//     * @Assert\NotBlank()
//     */
//    public $godaVixod;

    public function __construct(string $plemmatka, string $uchastie)
    {
        $this->plemmatka = $plemmatka;
        $this->uchastie = $uchastie;
        $this->type = Type::NABLUD;
        $this->priority = 2;

    }
}
