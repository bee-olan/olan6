<?php

declare(strict_types=1);

namespace App\Model\Mesto\Entity\Okrugs\Oblasts\Raions;

use App\Model\Mesto\UseCase\Okrugs\Oblasts\Oblast;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="rabota_u4astniki_mesto_oblast_raions")
 */
class Raion
{
    /**
     * @var Oblast
     * @ORM\ManyToOne(targetEntity="App\Model\Rabota\Entity\U4astniki\Mesto\Oblasts\Oblast", inversedBy="raions")
     * @ORM\JoinColumn(name="oblast_id", referencedColumnName="id", nullable=false)
     */
    private $oblast;

    /**
     * @var Id
     * @ORM\Column(type="rabota_u4astniki_mesto_oblast_raion_id")
     * @ORM\Id
     */
    private $id;

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

    public function __construct(Oblast $oblast, Id $id,
                                string $name,
                                string $nomer,
                                string $mesto
    )
    {
        $this->oblast = $oblast;
        $this->id = $id;
        $this->name = $name;
        $this->nomer = $nomer;
        $this->mesto = $mesto;
    }

    public function edit(string $name, string $nomer, string $mesto ): void
    {
        $this->name = $name;
        $this->nomer = $nomer;
        $this->mesto = $mesto;
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