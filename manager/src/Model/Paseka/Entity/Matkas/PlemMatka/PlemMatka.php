<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Matkas\PlemMatka;

use App\Model\Paseka\Entity\Matkas\PlemMatka\Department\Department;
use App\Model\Paseka\Entity\Matkas\PlemMatka\Department\Id as DepartmentId;

use Doctrine\Common\Collections\ArrayCollection;
use App\Model\Paseka\Entity\Matkas\Sparings\Sparing;
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
     * @var Sparing
     * @ORM\ManyToOne(targetEntity="App\Model\Paseka\Entity\Matkas\Sparings\Sparing")
     * @ORM\JoinColumn(name="sparing_id", referencedColumnName="id", nullable=false)
     */
    private $sparing;

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
    private $uchastnik;

    public function __construct( Id $id,
                                 string $name,
                                 int $sort,
                                 Sparing $sparing,
                                 string $uchastieId,
                                 string  $mesto,
                                 int  $persona,
                                 string $rasaNomId,
                                 string $title
                                  )
    {
        $this->id = $id;
        $this->name = $name;
        $this->sort = $sort;
        $this->status = Status::active();
        $this->uchastieId = $uchastieId;
        $this->sparing = $sparing;
        $this->mesto = $mesto;
        $this->persona = $persona;
        $this->rasaNomId = $rasaNomId;
        $this->title = $title;
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

    public function removeDepartment(DepartmentId $id): void
    {
        foreach ($this->departments as $department) {
            if ($department->getId()->isEqual($id)) {
                $this->departments->removeElement($department);
                return;
            }
        }
        throw new \DomainException('Отдел не найден.');
    }
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

    public function getSparing(): Sparing
    {
        return $this->sparing;
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
}
