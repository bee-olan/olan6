<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Sezons\Tochkas\Wzatoks;

use App\Model\Paseka\Entity\Sezons\Tochkas\Tochka;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="paseka_sezon_tochka_wzatoks")
 */
class Wzatok
{
    /**
     * @var Tochka
     * @ORM\ManyToOne(targetEntity="App\Model\Paseka\Entity\Sezons\Tochkas\Tochka", inversedBy="wzatoks")
     * @ORM\JoinColumn(name="tochka_id", referencedColumnName="id", nullable=false)
     */
    private $tochka;

    /**
     * @var Id
     * @ORM\Column(type="paseka_sezon_tochka_wzatok_id")
     * @ORM\Id
     */
    private $id;

    /**
     * @var \DateTimeImmutable|null
     * @ORM\Column(type="date_immutable", nullable=true)
     */
    private $startDate; // начало сезона

    /**
     * @var \DateTimeImmutable|null
     * @ORM\Column(type="date_immutable", nullable=true)
     */
    private $pobelkaDate; //

    /**
     * @var \DateTimeImmutable|null
     * @ORM\Column(type="date_immutable", nullable=true)
     */
    private $endDate; // конец сезона


    /**
     * @ORM\Column(type="smallint")
     */
    private $rasstojan;

    /**
     * @ORM\Column(type="smallint")
     */
    private $nomerwz;


    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $gruppa;

	
//	 /**
//     * @var ArrayCollection|Istoria[]
//     * @ORM\OneToMany(
//     *     targetEntity="App\Model\Sezons\Entity\Sxemas\Istorias\Istoria",
//     *     mappedBy="sxema", orphanRemoval=true, cascade={"all"}
//     * )
//     * @ORM\OrderBy({"name" = "ASC"})
//     */
//    private $istorias;

    public function __construct( Tochka $tochka, Id $id,
                                int $rasstojan,
                                \DateTimeImmutable $startDate,
                                \DateTimeImmutable $pobelkaDate,
                                \DateTimeImmutable $endDate,
                                int $nomerwz,
                                string $gruppa
                                )
    {
        $this->tochka = $tochka;
        $this->id = $id;
        $this->rasstojan = $rasstojan;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->pobelkaDate = $pobelkaDate;
        $this->nomerwz = $nomerwz;
        $this->gruppa = $gruppa;
//		$this->nomers = new ArrayCollection();
    }

    public function editRasstojan(int $rasstojan): void
    {
        $this->rasstojan = $rasstojan;

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

    public function getRasstojan(): int
    {
        return $this->rasstojan;
    }

    public function getStartDate(): \DateTimeImmutable
    {
        return $this->startDate;
    }

    public function getPobelkaDate(): \DateTimeImmutable
    {
        return $this->pobelkaDate;
    }

    public function getEndDate(): \DateTimeImmutable
    {
        return $this->endDate;
    }

    public function getNomerwz(): int
    {
        return $this->nomerwz;
    }

    public function getGruppa(): string
    {
        return $this->gruppa;
    }



}
