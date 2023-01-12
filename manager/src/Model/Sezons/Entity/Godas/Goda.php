<?php

declare(strict_types=1);

namespace App\Model\Sezons\Entity\Godas;

use App\Model\Sezons\Entity\Godas\Wzatoks\Wzatok;
use App\Model\Sezons\Entity\Godas\Wzatoks\Id as WzatokId;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sezons_godas")
 */
class Goda
{
    /**
     * @var Id
     * @ORM\Column(type="sezons_goda_id")
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
     * @var ArrayCollection|Wzatok[]
     * @ORM\OneToMany(
     *     targetEntity="App\Model\Sezons\Entity\Godas\Wzatoks\Wzatok",
     *     mappedBy="goda", orphanRemoval=true, cascade={"all"}
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $wzatoks;

    public function __construct(Id $id, int $god , string $sezon)
    {
        $this->id = $id;
        $this->god = $god;
        $this->sezon = $sezon;
        $this->wzatoks = new ArrayCollection();
    }

    public function edit(int $god, string $sezon): void
    {
        $this->god = $god;
        $this->sezon = $sezon;
    }
//	///////////////////////
    public function addWzatok(WzatokId $id,
                              ?string $content,
                              int $kolwz,
                              int $gruppa,
                              string $uchastieId
                            ): void
    {
//        foreach ($this->wzatoks as $wzatok) {
//            if ($wzatok->isNameStarEqual($kolwz)) {
//                throw new \DomainException('Это тномер взятка уже существует. ');
//            }
//        }

        $this->wzatoks->add(new Wzatok($this,
                                $id,
                                $content,
                                $kolwz,
                                $gruppa,
                                $uchastieId));
    }

    public function editWzatok(WzatokId $id,
                               ?string $content,
                               int $kolwz
                                ): void
    {
        foreach ($this->wzatoks as $current) {
            if ($current->getId()->isEqual($id)) {
                $current->edit($content, $kolwz );
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
