<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Sezons\Tochkas;

//use App\Model\Sezons\Entity\Sxemas\Wzatoks\Wzatok;
//use App\Model\Sezons\Entity\Sxemas\Wzatoks\Id as WzatokId;


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
     * @ORM\ManyToOne(targetEntity="App\Model\Paseka\Entity\Sezons\Godas\UchasGoda", inversedBy="tochkas")
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

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $gruppa;
	
//	 /**
//     * @var ArrayCollection|Wzatok[]
//     * @ORM\OneToMany(
//     *     targetEntity="App\Model\Sezons\Entity\Sxemas\Wzatoks\Wzatok",
//     *     mappedBy="tochka", orphanRemoval=true, cascade={"all"}
//     * )
//     * @ORM\OrderBy({"name" = "ASC"})
//     */
//    private $wzatoks;

    public function __construct(
                                UchasGoda $uchasgoda,
                                Id $id,
                                int $kolwz,
                                string $gruppa
                                    )
    {
        $this->uchasgoda = $uchasgoda;
        $this->id = $id;
        $this->kolwz = $kolwz;
        $this->gruppa = $gruppa;
//        $this->wzatoks = new ArrayCollection();
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
//    public function addWzatok(WzatokId $id,
//                                int $kolwz,
//                                 string $gruppa
//                                ): void
//    {
//        foreach ($this->wzatoks as $wzatok) {
//            if ($wzatok->isNameStarEqual($nameStar)) {
//                throw new \DomainException('Линия уже существует. Попробуйте для
//                этой линии добавить свой номер');
//            }
//        }
//
//        $this->wzatoks->add(new Wzatok($this,
//									$id,
//                                    $rasstojan,
//                                    $startDate,
//                                    $pobelkaDate,
//                                    $endDate,
//                                    $nomerwz
//        ));
//    }

//    public function editWzatok(WzatokId $id,
//                                string $name,
//                                string $nameStar,
//                                string $title
//                                ): void
//    {
//        foreach ($this->wzatoks as $current) {
//            if ($current->getId()->isEqual($id)) {
//                $current->edit($name, $nameStar, $title );
//                return;
//            }
//        }
//        throw new \DomainException('Wzatok is not found.');
//    }

//    public function removeWzatok(WzatokId $id): void
//    {
//        foreach ($this->wzatoks as $wzatok) {
//            if ($wzatok->getId()->isEqual($id)) {
//                $this->wzatoks->removeElement($wzatok);
//                return;
//            }
//        }
//        throw new \DomainException('Wzatok is not found.');
//    }
//
//	 public function getWzatoks()
//    {
//        return $this->wzatoks->toArray();
//    }
//
//
//    public function getWzatok(WzatokId $id): Wzatok
//    {
//        foreach ($this->wzatoks as $wzatok) {
//            if ($wzatok->getId()->isEqual($id)) {
//                return $wzatok;
//            }
//        }
//        throw new \DomainException('Wzatok is not found.');
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


    public function getGruppa(): string
    {
        return $this->gruppa;
    }

}
