<?php

declare(strict_types=1);

namespace App\Model\Mesto\Entity\Okrugs\Oblasts;

use App\Model\Mesto\Entity\Okrugs\Okrug;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="mesto_okrug_oblasts")
 */
class Oblast
{
    /**
     * @var Id
     * @ORM\Column(type="mesto_okrug_oblast_id")
     * @ORM\Id
     */
    private $id;

    /**
     * @var Okrug
     * @ORM\ManyToOne(targetEntity="App\Model\Mesto\Entity\Okrugs\Okrug", inversedBy="oblasts")
     * @ORM\JoinColumn(name="okrug_id", referencedColumnName="id", nullable=false)
     */
    private $okrug;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $nomer;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $mesto;

    public function __construct(Okrug $okrug,
                                Id $id,
                                string $name,
                                string $nomer,
                                string $mesto
    )
    {
        $this->okrug = $okrug;
        $this->id = $id;
        $this->name = $name;
        $this->nomer = $nomer;
        $this->mesto = $mesto;
       // $this->raions = new ArrayCollection();
    }

    public function edit(string $name, string $nomer ): void
    {
        $this->name = $name;
        $this->nomer = $nomer;
    }

// равно Ли Имя
    public function isNameEqual(string $name): bool
    {
        return $this->name === $name;
    }

    public function isNomerEqual(string $nomer): bool
    {
        return $this->nomer === $nomer;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNomer(): string
    {
        return $this->nomer;
    }

    public function getMesto(): string
    {
        return $this->mesto;
    }
}