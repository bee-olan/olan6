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
     * UchasGoda constructor.
     * @param Goda $goda
     * @param Uchastie $uchastie
     * @throws \Exception
     */
    public function __construct(Goda $goda, Uchastie $uchastie )
    {      
        $this->id = Uuid::uuid4()->toString();
        $this->goda = $goda;
        $this->uchastie = $uchastie;        
    }

    public function isForUchastie(UchastieId $id): bool
    {
        return $this->uchastie->getId()->isEqual($id);
    }

    public function getUchastie(): Uchastie
    {
        return $this->uchastie;
    }

}    