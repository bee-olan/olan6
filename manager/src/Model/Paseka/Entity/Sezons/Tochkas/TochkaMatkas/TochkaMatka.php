<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Sezons\Tochkas\TochkaMatkas;

use App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatka;
use App\Model\Paseka\Entity\Sezons\Tochkas\Tochka;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="paseka_sezon_tochka_tochmatkas")
 */
class TochkaMatka
{
    /**
     * @var Tochka
     * @ORM\ManyToOne(targetEntity="App\Model\Paseka\Entity\Sezons\Tochkas\Tochka", inversedBy="tochmatkas")
     * @ORM\JoinColumn(name="tochka_id", referencedColumnName="id", nullable=false)
     */
    private $tochka;


    /**
     * @var ChildMatka
     * @ORM\ManyToOne(targetEntity="App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatka")
     * @ORM\JoinColumn(name="childmatka_id", referencedColumnName="id", nullable=false)
     */
    private $childmatka;

    /**
     * @var Id
     * @ORM\Column(type="paseka_sezon_tochka_tochmatka_id")
     * @ORM\Id
     */
    private $id;


	
//	 /**
//     * @var ArrayCollection|Istoria[]
//     * @ORM\OneToMany(
//     *     targetEntity="App\Model\Sezons\Entity\Sxemas\Istorias\Istoria",
//     *     mappedBy="sxema", orphanRemoval=true, cascade={"all"}
//     * )
//     * @ORM\OrderBy({"name" = "ASC"})
//     */
//    private $istorias;

    public function __construct( Tochka $tochka,
                                ChildMatka $childmatka
                                )
    {
        $this->id = Uuid::uuid4()->toString();
        $this->tochka = $tochka;
        $this->childmatka = $childmatka;
//		$this->nomers = new ArrayCollection();
    }

    public function editRasstojan(int $rasstojan): void
    {
        $this->rasstojan = $rasstojan;

    }



//    public function isGruppaEqual(string $gruppa): bool
//    {
//        return $this->gruppa === $gruppa;
//    }
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

    /**
     * @return ChildMatka
     */
    public function getChildmatka(): ChildMatka
    {
        return $this->childmatka;
    }




}
