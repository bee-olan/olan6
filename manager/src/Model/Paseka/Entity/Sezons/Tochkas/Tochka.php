<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Sezons\Tochkas;

//use App\Model\Sezons\Entity\Sxemas\Istorias\Istoria;
//use App\Model\Sezons\Entity\Sxemas\Istorias\Id as IstoriaId;


use App\Model\Paseka\Entity\Sezons\Godas\UchasGoda;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="paseka_sezon_tochkas")
 */
class Tochka
{
    /**
     * @var UchasGoda
     * @ORM\ManyToOne(targetEntity="App\Model\Paseka\Entity\Sezons\Godas\UchasGoda", inversedBy="linias")
     * @ORM\JoinColumn(name="uchasgoda_id", referencedColumnName="id", nullable=false)
     */
    private $uchasgoda;

    /**
     * @var Id
     * @ORM\Column(type="paseka_sezon_tochka_id")
     * @ORM\Id
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $kolwz;

	
//	 /**
//     * @var ArrayCollection|Istoria[]
//     * @ORM\OneToMany(
//     *     targetEntity="App\Model\Sezons\Entity\Sxemas\Istorias\Istoria",
//     *     mappedBy="sxema", orphanRemoval=true, cascade={"all"}
//     * )
//     * @ORM\OrderBy({"name" = "ASC"})
//     */
//    private $istorias;

    public function __construct(
                                UchasGoda $uchasgoda,
                                 Id $id,
                                 int $kolwz
                                    )
    {
        $this->uchasgoda = $uchasgoda;
        $this->id = $id;
        $this->kolwz = $kolwz;
//        $this->istorias = new ArrayCollection();
    }

        public function edit( int $kolwz): void
    {
        $this->kolwz = $kolwz;

    }
    public function isGruppaEqual(string $gruppa): bool
    {
        return $this->gruppa === $gruppa;
    }
//	///////////////////////
//    public function addIstoria(IstoriaId $id,
//                               int $rasstojan,
//                               \DateTimeImmutable $startDate,
//                               \DateTimeImmutable $pobelkaDate,
//                               \DateTimeImmutable $endDate,
//                                int $nomerwz
//                                ): void
//    {
//        foreach ($this->istorias as $istoria) {
//            if ($istoria->isNameStarEqual($nameStar)) {
//                throw new \DomainException('Линия уже существует. Попробуйте для
//                этой линии добавить свой номер');
//            }
//        }
//
//        $this->istorias->add(new Istoria($this,
//									$id,
//                                    $rasstojan,
//                                    $startDate,
//                                    $pobelkaDate,
//                                    $endDate,
//                                    $nomerwz
//        ));
//    }

//    public function editIstoria(IstoriaId $id,
//                                string $name,
//                                string $nameStar,
//                                string $title
//                                ): void
//    {
//        foreach ($this->istorias as $current) {
//            if ($current->getId()->isEqual($id)) {
//                $current->edit($name, $nameStar, $title );
//                return;
//            }
//        }
//        throw new \DomainException('Istoria is not found.');
//    }

//    public function removeIstoria(IstoriaId $id): void
//    {
//        foreach ($this->istorias as $istoria) {
//            if ($istoria->getId()->isEqual($id)) {
//                $this->istorias->removeElement($istoria);
//                return;
//            }
//        }
//        throw new \DomainException('Istoria is not found.');
//    }
//
//	 public function getIstorias()
//    {
//        return $this->istorias->toArray();
//    }
//
//
//    public function getIstoria(IstoriaId $id): Istoria
//    {
//        foreach ($this->istorias as $istoria) {
//            if ($istoria->getId()->isEqual($id)) {
//                return $istoria;
//            }
//        }
//        throw new \DomainException('Istoria is not found.');
//    }
/////////////////////////////////////////
    public function getId(): Id
    {
        return $this->id;
    }

    public function getKolwz(): int
    {
        return $this->kolwz;
    }

}
