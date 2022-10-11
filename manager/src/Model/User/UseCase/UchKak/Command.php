<?php

declare(strict_types=1);

namespace App\Model\User\UseCase\UchKak;

use App\Model\User\Entity\User\User;
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
    public static function fromUser(User $user): self
    {
        $command = new self($user->getId()->getValue());
        $command->uchkak = $user->getUchkak()->getName();
        return $command;
    }
}
