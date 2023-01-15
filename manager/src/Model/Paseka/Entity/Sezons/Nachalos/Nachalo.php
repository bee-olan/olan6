<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Sezons\Nachalos;

use App\Model\Sezons\Entity\Godas\Goda;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="paseka_sezons_nachalos")
 */
class Nachalo
{
    /**
     * @var Id
     * @ORM\Column(type="paseka_sezons_nachalo_id")
     * @ORM\Id
     */
    private $id;
    /**
     * @var Goda
     * @ORM\ManyToOne(targetEntity="App\Model\Paseka\Entity\Sezons\Godas\Goda")
     * @ORM\JoinColumn(name="goda_id", referencedColumnName="id", nullable=false)
     */
    private $goda;

    /**
     * @ORM\Column(type="smallint")
     */
    private $koltochek;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $gruppa;

//    /**
//     * @ORM\Version()
//     * @ORM\Column(type="integer")
//     */
//    private $version;

    public function __construct(Id $id,  Goda $goda,
                                int $koltochek,
                                string $gruppa
                                )
    {
        $this->id = $id;
        $this->goda = $goda;
        $this->koltochek = $koltochek;
        $this->gruppa = $gruppa;

    }

    /**
     * @return string
     */
    public function getGruppa(): string
    {
        return $this->gruppa;
    }

    /**
     * @return int
     */
    public function getKoltochek(): int
    {
        return $this->koltochek;
    }

    public function edit(string $koltochek): void
    {
        $this->koltochek = $koltochek;
    }

    public function move(Goda $goda): void
    {
        $this->goda = $goda;
    }


    public function getId(): Id
    {
        return $this->id;
    }


    public function getGoda(): Goda
    {
        return $this->goda;
    }


}
