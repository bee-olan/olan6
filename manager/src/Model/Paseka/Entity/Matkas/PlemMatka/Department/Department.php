<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Matkas\PlemMatka\Department;

use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatka;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="paseka_matkas_plemmatka_departments")
 */
class Department
{
    /**
     * @var PlemMatka
     * @ORM\ManyToOne(targetEntity="App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatka", inversedBy="departments")
     * @ORM\JoinColumn(name="plemmatka_id", referencedColumnName="id", nullable=false)
     */
    private $plemmatka;
    /**
     * @var Id
     * @ORM\Column(type="paseka_matkas_plemmatka_department_id")
     * @ORM\Id
     */
    private $id;
    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $name;

    public function __construct(PlemMatka $plemmatka, Id $id, string $name)
    {
        $this->plemmatka = $plemmatka;
        $this->id = $id;
        $this->name = $name;
    }

    public function edit(string $name): void
    {
        $this->name = $name;

    }

    public function isNameEqual(string $name): bool
    {
        return $this->name === $name;
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
