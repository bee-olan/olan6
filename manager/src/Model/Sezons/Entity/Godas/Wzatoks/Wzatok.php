<?php

declare(strict_types=1);

namespace App\Model\Sezons\Entity\Godas\Wzatoks;

//use App\Model\Sezons\Entity\Sxemas\Istorias\Istoria;
//use App\Model\Sezons\Entity\Sxemas\Istorias\Id as IstoriaId;

use App\Model\Sezons\Entity\Godas\Goda;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sezon_goda_wzatoks")
 */
class Wzatok
{
    /**
     * @var Goda
     * @ORM\ManyToOne(targetEntity="App\Model\Sezons\Entity\Godas\Goda", inversedBy="linias")
     * @ORM\JoinColumn(name="goda_id", referencedColumnName="id", nullable=false)
     */
    private $goda;

    /**
     * @var Id
     * @ORM\Column(type="sezon_goda_wzatok_id")
     * @ORM\Id
     */
    private $id;
    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\Column(type="smallint")
     */
    private $kolwz;

//    /**
//     * @ORM\Column(type="smallint")
//     */
//    private $koltochek;

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

    public function __construct( Goda $goda, Id $id,
                                 ?string $content,
                                 int $kolwz,
                                 string $gruppa
//                                 int $koltochek
                                    )
    {
        $this->goda = $goda;
        $this->id = $id;
        $this->content = $content;
        $this->kolwz = $kolwz;
        $this->gruppa = $gruppa;
//        $this->koltochek = $koltochek;
//        $this->istorias = new ArrayCollection();
    }

        public function edit(string $content, int $kolwz): void
    {
        $this->content = $content;
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
//    public function getKoltochek(): int
//    {
//        return $this->koltochek;
//    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getGruppa(): string
    {
        return $this->gruppa;
    }

}
