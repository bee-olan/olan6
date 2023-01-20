<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Sezons\Godas;

use App\Model\Paseka\Entity\Sezons\Tochkas\Tochka;
use App\Model\Paseka\Entity\Sezons\Tochkas\Id as TochkaId;

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
     * @var ArrayCollection|Tochka[]
     * @ORM\OneToMany(
     *     targetEntity="App\Model\Paseka\Entity\Sezons\Tochkas\Tochka",
     *     mappedBy="uchasgoda", orphanRemoval=true, cascade={"all"}
     * )
     * @ORM\OrderBy({"gruppa" = "ASC"})
     */
    private $tochkas;

//    /**
//     * UchasGoda constructor.
//     * @param Goda $goda
//     * @param Uchastie $uchastie
//     * @param int $koltochek
//     * @param string $gruppa
//     * @throws \Exception
//     */
    public function __construct(Goda $goda, Uchastie $uchastie,
                                int $koltochek,
                                string $gruppa  )
    {      
        $this->id = Uuid::uuid4()->toString();
        $this->goda = $goda;
        $this->uchastie = $uchastie;
        $this->koltochek = $koltochek;
        $this->gruppa = $gruppa;
        $this->tochkas = new ArrayCollection();
    }
////////////////////
    public function addTochka(TochkaId $id,
                              int $kolwz,
                              string $gruppa,
                              string $name,
                               int $tochka
                            ): void
    {

//dd($tochka);
        foreach ($this->tochkas as $tochkaa) {
            if ($tochkaa->isNameEqual($gruppa)) {
                throw new \DomainException('ГРУППА уже существует.');
            }
        }

        $this->tochkas->add(new Tochka($this,
                                        $id,
                                        $kolwz,
                                        $gruppa,
                                        $name,  $tochka));
    }

    public function editTochka(TochkaId $id,
                               int $kolwz,
                               string $name
                            ): void
    {
        foreach ($this->tochkas as $current) {
            if ($current->getId()->isEqual($id)) {
                $current->edit( $kolwz, $name );
                return;
            }
        }
        throw new \DomainException('Tochka is not found.');
    }

    public function removeTochka(TochkaId $id): void
    {
        foreach ($this->tochkas as $tochka) {
            if ($tochka->getId()->isEqual($id)) {
                $this->tochkas->removeElement($tochka);
                return;
            }
        }
        throw new \DomainException('Tochka is not found.');
    }

    /**
     * @return Tochka[]|ArrayCollection
     */
    public function getTochkas()
    {
        return $this->tochkas;
    }

    /**
     * @return Goda
     */
    public function getGoda(): Goda
    {
        return $this->goda;
    }

    public function getTochka(TochkaId $id): Tochka
    {
        foreach ($this->tochkas as $tochka) {
            if ($tochka->getId()->isEqual($id)) {
                return $tochka;
            }
        }
        throw new \DomainException('Tochka is not found.');
    }
//////////////
    public function isForUchastie(UchastieId $id): bool
    {
        return $this->uchastie->getId()->isEqual($id);
    }

    public function getId(): string
    {
        return $this->id;
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