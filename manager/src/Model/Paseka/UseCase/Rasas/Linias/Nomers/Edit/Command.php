<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Rasas\Linias\Nomers\Edit;

use App\Model\Paseka\Entity\Rasas\Linias\Nomers\Nomer;
use App\Model\Paseka\Entity\Rasas\Linias\Linia;
use Symfony\Component\Validator\Constraints as Assert;

class Command
{
    /**
     * @Assert\NotBlank()
     */
    public $linia;
    /**
     * @Assert\NotBlank()
     */
    public $id;

    /**
     * @Assert\NotBlank()
     */
    public $name;

         /**
     * @Assert\NotBlank()
     */
    public $nameStar;
	
	 /**
     * @Assert\NotBlank()
     */
    public $title;

    public function __construct(string $linia, string $id)
    {
        
        $this->linia = $linia;
        $this->id = $id;
    }

    public static function fromNomer(Linia $linia, Nomer $nomer): self
    {
        //dd($linia);
        $command = new self($linia->getId()->getValue(), $nomer->getId()->getValue());
        $command->name = $nomer->getName();
		$command->nameStar = $nomer->getNameStar();
		$command->title = $nomer->getTitle();
        return $command;
    }
}
