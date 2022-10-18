<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Uchasties\Uchastie\Edit;

use App\Model\Paseka\Entity\Uchasties\Uchastie\Uchastie;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $id;
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $firstName;
    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $lastName;

    /**
     * @var string
     * @Assert\NotBlank()
     */
    public $lastNike;

    // /**
    //  * @var string
    //  * @Assert\Email()
    //  */
    // public $email;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromUchastie(Uchastie $uchastie): self
    {
        $command = new self($uchastie->getId()->getValue());
        $command->firstName = $uchastie->getName()->getFirst();
        $command->lastName = $uchastie->getName()->getLast();
        $command->lastNike = $uchastie->getName()->getNike();
        // $command->email = $uchastie->getEmail()->getValue();
        return $command;
    }
}
