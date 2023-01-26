<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Sezons\Tochkas;

use App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatka;
use App\Model\Paseka\Entity\Sezons\Tochkas\TochkaMatkas\TochkaMatka;
use App\Model\Paseka\Entity\Sezons\Tochkas\Wzatoks\Wzatok;
use App\Model\Paseka\Entity\Sezons\Tochkas\Wzatoks\Id as WzatokId;

use App\Model\Paseka\Entity\Sezons\Godas\UchasGoda;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

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

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="smallint")
     */
    private $tochka;
	
	/**
    * @var ArrayCollection|Wzatok[]
    * @ORM\OneToMany(
    *     targetEntity="App\Model\Paseka\Entity\Sezons\Tochkas\Wzatoks\Wzatok",
    *     mappedBy="tochka", orphanRemoval=true, cascade={"all"}
    * )
    * @ORM\OrderBy({"gruppa" = "ASC"})
    */
   private $wzatoks;

    /**
     * @var ArrayCollection|TochkaMatkas[]
     * @ORM\OneToMany(targetEntity="App\Model\Paseka\Entity\Sezons\Tochkas\TochkaMatkas\TochkaMatka",
     *     mappedBy="tochka", orphanRemoval=true, cascade={"all"})
     */
    private $tochmatkas;

    public function __construct(
                                UchasGoda $uchasgoda,
                                Id $id,
                                int $kolwz,
                                string $gruppa,
                                string $name,
                                int $tochka
                                    )
    {
        $this->uchasgoda = $uchasgoda;
        $this->id = $id;
        $this->kolwz = $kolwz;
        $this->gruppa = $gruppa;
        $this->name = $name;
        $this->tochka = $tochka;
       $this->wzatoks = new ArrayCollection();
        $this->tochmatkas = new ArrayCollection();
    }

        public function edit( int $kolwz): void
    {
        $this->kolwz = $kolwz;

    }
    public function isNameEqual(string $gruppa): bool
    {
        return $this->gruppa === $gruppa;
    }
///////////////////////////////////////////
    /**
     * @param ChildMatka $childmatka
     * @throws \Exception
     */
    public function addChildMatka(ChildMatka $childmatka, $gruppa): void
    {
        foreach ($this->tochmatkas as $tochmatka) {
//            if ($tochmatka->isForUchastie($childmatka->getId())) {
//                throw new \DomainException('Маточка уже закреплена к  точку.');
//            }
        }
        $this->tochmatkas->add(new TochkaMatka($this, $childmatka ,$gruppa   ));
    }




    public function getTochmatkas()
    {
        return $this->tochmatkas->toArray();
    }

	///////////////////////
   public function addWzatok(WzatokId $id,
                               int $rasstojan,
                               \DateTimeImmutable $startDate,
                               \DateTimeImmutable $pobelkaDate,
                               \DateTimeImmutable $endDate,
                                int $nomerwz,
                                string $gruppa,
                                int $rabotad,
                                int $rabotach
                               ): void
   {
       foreach ($this->wzatoks as $wzatok) {
           if ($wzatok->isGruppaEqual($gruppa)) {
               throw new \DomainException('Группа для взятка уже существует. Изените номер взятка');
           }
       }
       
       $this->wzatoks->add(new Wzatok($this,
									$id,
                                    $rasstojan,
                                    $startDate,
                                    $pobelkaDate,
                                    $endDate,
                                    $nomerwz,
                                    $gruppa,
                                   $rabotad,
                                   $rabotach
       ));
   }
    public function editWzaDate(WzatokId $id,
                                \DateTimeImmutable $startDate,
                                \DateTimeImmutable $pobelkaDate,
                                \DateTimeImmutable $endDate
                            ): void
    {
        foreach ($this->wzatoks as $current) {
            if ($current->getId()->isEqual($id)) {
                $current->editDate($startDate, $pobelkaDate, $endDate );
                return;
            }
        }
        throw new \DomainException('Wzatok is not found.');
    }

   public function editWzatok(WzatokId $id,
                               int $rasstojan
                               ): void
   {
       foreach ($this->wzatoks as $current) {
           if ($current->getId()->isEqual($id)) {
               $current->editRasstojan($rasstojan );
               return;
           }
       }
       throw new \DomainException('Wzatok is not found.');
   }

   public function removeWzatok(WzatokId $id): void
   {
       foreach ($this->wzatoks as $wzatok) {
           if ($wzatok->getId()->isEqual($id)) {
               $this->wzatoks->removeElement($wzatok);
               return;
           }
       }
       throw new \DomainException('Wzatok is not found.');
   }

//    /**
//     * @return Wzatok[]|ArrayCollection
//     */
//    public function getWzatoks()
//    {
//        return $this->wzatoks;
//    }

   public function getWzatoks()
   {
       return $this->wzatoks->toArray();
   }


   public function getWzatok(WzatokId $id): Wzatok
   {
       foreach ($this->wzatoks as $wzatok) {
           if ($wzatok->getId()->isEqual($id)) {
               return $wzatok;
           }
       }
       throw new \DomainException('Wzatok is not found.');
   }
/////////////////////////////////////////
    public function getId(): Id
    {
        return $this->id;
    }

    public function getKolwz(): int
    {
        return $this->kolwz;
    }

    /**
     * @return string
     */
    public function getGruppa(): string
    {
        return $this->gruppa;
    }


   public function getName(): string
   {
       return $this->name;
   }
//    /**
//     * @return int
//     */
    public function getTochka(): int
    {
        return $this->tochka;
    }

    /**
     * @return UchasGoda
     */
    public function getUchasgoda(): UchasGoda
    {
        return $this->uchasgoda;
    }


}
