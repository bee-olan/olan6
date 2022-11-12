<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Matkas\PlemMatka;

use App\Model\Paseka\Entity\Uchasties\Uchastie\Uchastie;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Id as UchastieId;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="paseka_matkas_plemmatkas_uchastniks", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"plemmatka_id", "uchastie_id"})
 * })
 */
class Uchastnik
{
    /**
     * @var string
     * @ORM\Column(type="guid")
     * @ORM\Id
     */
    private $id;

    /**
     * @var PlemMatka
     * @ORM\ManyToOne(targetEntity="PlemMatka", inversedBy="uchasniks")
     * @ORM\JoinColumn(name="plemmatka_id", referencedColumnName="id", nullable=false)
     */
    private $plemmatka;

    /**
     * @var Uchastie
     * @ORM\ManyToOne(targetEntity="App\Model\Paseka\Entity\Uchasties\Uchastie\Uchastie")
     * @ORM\JoinColumn(name="uchastie_id", referencedColumnName="id", nullable=false)
     */
    private $uchastie;
//     * @param ArrayCollection|Department[] $departments
//     * @param ArrayCollection|Role[] $roles
    /**
     * Membership constructor.
     * @param PlemMatka $plemmatka
     * @param Uchastie $uchastie
     * @throws \Exception
     */
    public function __construct(PlemMatka $plemmatka, Uchastie $uchastie
                               // , array $departments, array $roles
                                )
    {
//        $this->guardDepartments($departments);
//        $this->guardRoles($roles);

        $this->id = Uuid::uuid4()->toString();
        $this->plemmatka = $plemmatka;
        $this->uchastie = $uchastie;
//        $this->departments = new ArrayCollection($departments);
//        $this->roles = new ArrayCollection($roles);
    }

    public function isForUchastie(UchastieId $id): bool
    {
        return $this->uchastie->getId()->isEqual($id);
    }

    public function getUchastie(): Uchastie
    {
        return $this->uchastie;
    }


}