<?php

declare(strict_types=1);

namespace App\Model\Sezons\Entity\Sezon;

//use App\Model\Paseka\Entity\Uchasties\Group\Group;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sezons_sezons")
 */
class Sezon
{
    /**
     * @var Id
     * @ORM\Column(type="sezons_sezon_id")
     * @ORM\Id
     */
    private $id;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $god;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $sezon;


    public function __construct(Id $id, int $god , string $sezon)
    {
        $this->id = $id;
        $this->god = $god;
        $this->sezon = $sezon;

    }

//    public function edit(Name $name, Email $email): void
//    {
//        $this->name = $name;
//        $this->email = $email;
//    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getGod(): int
    {
        return $this->god;
    }

    public function getSezon(): string
    {
        return $this->sezon;
    }


}
