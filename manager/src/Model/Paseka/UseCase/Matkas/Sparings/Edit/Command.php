<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\Sparings\Edit;

use App\Model\Paseka\Entity\Matkas\Sparings\Sparing;
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
    public $name;
	
	 /**
     * @var string
     * @Assert\NotBlank()
     */
    public $title;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public static function fromSparing(Sparing $sparing): self
    {
        $command = new self($sparing->getId()->getValue());
        $command->name = $sparing->getName();
		$command->title = $sparing->getTitle();
        return $command;
    }
}
