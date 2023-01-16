<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Sezons\Godas;

use App\Model\Paseka\Entity\Uchasties\Uchastie\Uchastie;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Id as UchastieId;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="paseka_sezons_uchasgodas", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"goda_id", "uchastie_id"})
 * })
 */
class UchasGoda
{
    /**
     * @var string
     * @ORM\Column(type="guid")
     * @ORM\Id
     */
    private $id;

    /**
     * @var Goda
     * @ORM\ManyToOne(targetEntity="Goda", inversedBy="uchasgodas")
     * @ORM\JoinColumn(name="goda_id", referencedColumnName="id", nullable=false)
     */
    private $goda;

     /**
     * @var Uchastie
     * @ORM\ManyToOne(targetEntity="App\Model\Paseka\Entity\Uchasties\Uchastie\Uchastie")
     * @ORM\JoinColumn(name="uchastie_id", referencedColumnName="id", nullable=false)
     */
    private $uchastie;

    /**
     * @ORM\Column(type="smallint")
     */
    private $koltochek;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $gruppa;

    /**
     * UchasGoda constructor.
     * @param Goda $goda
     * @param Uchastie $uchastie
     * @param int $koltochek
     * @param string $gruppa
     * @throws \Exception
     */
    public function __construct(Goda $goda, Uchastie $uchastie,
                                int $koltochek,
                                string $gruppa  )
    {      
        $this->id = Uuid::uuid4()->toString();
        $this->goda = $goda;
        $this->uchastie = $uchastie;
        $this->koltochek = $koltochek;
        $this->gruppa = $gruppa;
    }

    public function isForUchastie(UchastieId $id): bool
    {
        return $this->uchastie->getId()->isEqual($id);
    }

    public function getUchastie(): Uchastie
    {
        return $this->uchastie;
    }

//    /**
//     * @return string
//     */
    public function getGruppa(): string
    {
        return $this->gruppa;
    }

//    /**
//     * @return int
//     */
    public function getKoltochek(): int
    {
        return $this->koltochek;
    }

}    