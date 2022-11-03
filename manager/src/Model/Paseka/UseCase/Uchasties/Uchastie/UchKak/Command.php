<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Uchasties\Uchastie\UchKak;

use App\Model\Paseka\Entity\Uchasties\Uchastie\Uchastie;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $id;
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $uchkak;

    public function __construct(string $id)
    {
        $this->id = $id;
    }
    public static function fromUchastie(Uchastie $uchastie): self
    {
        $command = new self($uchastie->getId()->getValue());
        $command->uchkak = $uchastie->getUchkak()->getName();
        return $command;
    }
}
