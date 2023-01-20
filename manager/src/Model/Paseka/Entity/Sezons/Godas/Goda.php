<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Sezons\Godas;

use App\Model\Paseka\Entity\Uchasties\Uchastie\Uchastie;
use Doctrine\Common\Collections\ArrayCollection;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="paseka_sezons_godas")
 */
class Goda
{
    /**
     * @var Id
     * @ORM\Column(type="paseka_sezons_goda_id")
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

    /**
     * @var ArrayCollection|UchasGoda[]
     * @ORM\OneToMany(targetEntity="UchasGoda",
     *     mappedBy="goda", orphanRemoval=true, cascade={"all"})
     */
    private $uchasgodas;


    public function __construct(Id $id, int $god , string $sezon)
    {
        $this->id = $id;
        $this->god = $god;
        $this->sezon = $sezon;
        $this->uchasgodas = new ArrayCollection();
    }

    public function edit(int $god, string $sezon): void
    {
        $this->god = $god;
        $this->sezon = $sezon;
    }
///////////////////////////////////
    /**
     * @param Uchastie $uchastie
     * @throws \Exception
     */
    public function addUchastie(Uchastie $uchastie, int $koltochek,  string $gruppa): void
    {
        foreach ($this->uchasgodas as $uchasgoda) {
            if ($uchasgoda->isForUchastie($uchastie->getId())) {
                throw new \DomainException('Участие уже существует.');
            }
        }
        $this->uchasgodas->add(new UchasGoda($this, $uchastie,
                                            $koltochek,
                                            $gruppa
                                                ));
    }

//    public function removeUchastie(UchastieId $id): void
//    {
//        foreach ($this->uchasties as $uchastie) {
//            if ($uchastie->getId()->isEqual($id)) {
//                $this->uchasties->removeElement($uchastie);
//                return;
//            }
//        }
//        throw new \DomainException('Uchastie is not found.');
//    }

    public function getUchasgodas()
    {
        return $this->uchasgodas->toArray();
    }

/////////////////////////
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
