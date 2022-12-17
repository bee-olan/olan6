<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Matkas\PlemMatka;

use App\Model\Paseka\Entity\Matkas\Kategoria\Kategoria;
use App\Model\Paseka\Entity\Matkas\Sparings\Sparing;

use App\Model\Paseka\Entity\Matkas\PlemMatka\Department\Department;
use App\Model\Paseka\Entity\Matkas\PlemMatka\Department\Id as DepartmentId;

use App\Model\Paseka\Entity\Matkas\Role\Role;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Uchastie;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Id as UchastieId;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="paseka_matkas_plemmatkas")
 */
class PlemMatka
{
    /**
     * @var Id
     * @ORM\Column(type="paseka_matkas_plemmatka_id")
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
     * @ORM\Column(type="string", name="uchastie_id")
     */
    private $uchastieId;

    /**
     * @var string
     * @ORM\Column(type="string", name="rasa_nom_id")
     */
    private $rasaNomId;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
      private $mesto;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $persona;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    private $sort;

    /**
     * @var Status
     * @ORM\Column(type="paseka_matkas_plemmatka_status", length=16)
     */
    private $status;

    /**
     * @var string
     * @ORM\Column(type="string")
     */
    private $nameKateg;

    /**
     * @var Kategoria
     * @ORM\ManyToOne(targetEntity="App\Model\Paseka\Entity\Matkas\Kategoria\Kategoria")
     * @ORM\JoinColumn(name="kategoria_id", referencedColumnName="id", nullable=false)
     */
    private $kategoria;

    /**
     * @var ArrayCollection|Department[]
     * @ORM\OneToMany(
     *     targetEntity="App\Model\Paseka\Entity\Matkas\PlemMatka\Department\Department",
     *     mappedBy="plemmatka", orphanRemoval=true, cascade={"all"}
     * )
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $departments;

    /**
     * @var ArrayCollection|Uchastnik[]
     * @ORM\OneToMany(targetEntity="Uchastnik", mappedBy="plemmatka", orphanRemoval=true, cascade={"all"})
     */
    private $uchastniks;

    public function __construct( Id $id,
                                 string $name,
                                 int $sort,
//                                 Sparing $sparing,
                                 string $uchastieId,
                                 string  $mesto,
                                 int  $persona,
                                 string $rasaNomId,
                                 string $title,
                                 string $nameKateg,
                                 Kategoria $kategoria
                                  )
    {
        $this->id = $id;
        $this->name = $name;
        $this->sort = $sort;
        $this->status = Status::active();
        $this->uchastieId = $uchastieId;
        $this->mesto = $mesto;
        $this->persona = $persona;
        $this->rasaNomId = $rasaNomId;
        $this->title = $title;
        $this->nameKateg = $nameKateg;
        $this->kategoria = $kategoria;
        $this->departments = new ArrayCollection();
        $this->uchastniks = new ArrayCollection();


    }
    ////////////////
    public function addDepartment(DepartmentId $id, string $name): void
    {
        foreach ($this->departments as $department) {
            if ($department->isNameEqual($name)) {
                throw new \DomainException('Отдел уже существует.');
            }
        }
        $this->departments->add(new Department($this, $id, $name));
    }

    public function editDepartment(DepartmentId $id, string $name): void
    {
        foreach ($this->departments as $current) {
            if ($current->getId()->isEqual($id)) {
                $current->edit($name);
                return;
            }
        }
        throw new \DomainException('Отдел не найден.');
    }

    // public function removeDepartment(DepartmentId $id): void
    // {
    //     foreach ($this->departments as $department) {
    //         if ($department->getId()->isEqual($id)) {
    //             foreach ($this->uchastniks as $uchastnik) {
    //                 if ($uchastnik->isForDepartment($id)) {
    //                     throw new \DomainException('Unable to remove department with uchasties.');
    //                 }
    //             }
    //             $this->departments->removeElement($department);
    //             return;
    //         }
    //     }
    //     throw new \DomainException('Отдел не найден.');
    // }
    ///////
    public function edit( string $title): void
    {
        //$this->sparing = $sparing;
        $this->title = $title;
    }

    public function move(Sparing $sparing): void
    {
        $this->sparing = $sparing;
    }

    public function archive(): void
    {
        if ($this->isArchived()) {
            throw new \DomainException('ПлемМатка уже заархивирована.');
        }
        $this->status = Status::archived();
    }

    public function reinstate(): void
    {
        if ($this->isActive()) {
            throw new \DomainException('ПлемМатка уже активена.');
        }
        $this->status = Status::active();
    }

    /**
     * @param Uchastie $uchastie
     * @param DepartmentId[] $departmentIds
     * @param Role[] $roles
     * @throws \Exception
     */
    public function addUchastie(Uchastie $uchastie, array $departmentIds, array $roles): void
    {
        foreach ($this->uchastniks as $uchastnik) {
            if ($uchastnik->isForUchastie($uchastie->getId())) {
                throw new \DomainException('Uchastie already exists.');
            }
        }
        $departments = array_map([$this, 'getDepartment'], $departmentIds);
        $this->uchastniks->add(new Uchastnik($this, $uchastie, $departments, $roles));
    }

    /**
     * @param UchastieId $uchastie
     * @param DepartmentId[] $departmentIds
     * @param Role[] $roles
     */
    public function editUchastie(UchastieId $uchastie, array $departmentIds, array $roles): void
    {
        foreach ($this->uchastniks as $uchastnik) {
            if ($uchastnik->isForUchastie($uchastie)) {
                $uchastnik->changeDepartments(array_map([$this, 'getDepartment'], $departmentIds));
                $uchastnik->changeRoles($roles);
                return;
            }
        }
        throw new \DomainException('Uchastie is not found.');
    }

    public function removeUchastie(UchastieId $uchastie): void
    {
        foreach ($this->uchastniks as $uchastnik) {
            if ($uchastnik->isForUchastie($uchastie)) {
                $this->uchastniks->removeElement($$this->uchastnik);
                return;
            }
        }
        throw new \DomainException('Uchastie is not found.');
    }

    public function isArchived(): bool
    {
        return $this->status->isArchived();
    }

    public function isActive(): bool
    {
        return $this->status->isActive();
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getNameKateg(): string
    {
        return $this->nameKateg;
    }

    public function getKategoria(): Kategoria
    {
        return $this->kategoria;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getMesto(): string
    {
        return $this->mesto;
    }

    public function getUchastieId(): string
    {
        return $this->uchastieId;
    }

    public function getPersona(): int
    {
        return $this->persona;
    }

    public function getSort(): int
    {
        return $this->sort;
    }

    public function getRasaNomId(): string
    {
        return $this->rasaNomId;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function getDepartments()
    {
        return $this->departments->toArray();
    }


    public function getDepartment(DepartmentId $id): Department
    {
        foreach ($this->departments as $department) {
            if ($department->getId()->isEqual($id)) {
                return $department;
            }
        }
        throw new \DomainException('Department is not found.');
    }

    public function getUchastniks()
    {
        return $this->uchastniks->toArray();
    }
}
