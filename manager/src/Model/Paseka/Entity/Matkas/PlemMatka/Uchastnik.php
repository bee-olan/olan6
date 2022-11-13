<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Matkas\PlemMatka;

use App\Model\Paseka\Entity\Matkas\PlemMatka\Department\Department;
use App\Model\Paseka\Entity\Matkas\Role\Role;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Uchastie;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Id as UchastieId;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="paseka_matkas_plemmatka_uchastniks", uniqueConstraints={
 *     @ORM\UniqueConstraint(columns={"plemmatka_id", "uchastie_id"})
 * })
 */
class Uchastnik
{
    /**
     * @var string
     * @ORM\Column(type="guid")
     * @ORM\Id
     */
    private $id;

    /**
     * @var PlemMatka
     * @ORM\ManyToOne(targetEntity="PlemMatka", inversedBy="uchasniks")
     * @ORM\JoinColumn(name="plemmatka_id", referencedColumnName="id", nullable=false)
     */
    private $plemmatka;

    /**
     * @var Uchastie
     * @ORM\ManyToOne(targetEntity="App\Model\Paseka\Entity\Uchasties\Uchastie\Uchastie")
     * @ORM\JoinColumn(name="uchastie_id", referencedColumnName="id", nullable=false)
     */
    private $uchastie;

    /**
     * @var ArrayCollection|Department[]
     * @ORM\ManyToMany(targetEntity="App\Model\Paseka\Entity\Matkas\PlemMatka\Department\Department")
     * @ORM\JoinTable(name="paseka_matkas_plemmatka_uchastnik_departments",
     *     joinColumns={@ORM\JoinColumn(name="uchastnik_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="department_id", referencedColumnName="id")}
     * )
     */
    private $departments;
    /**
     * @var ArrayCollection|Role[]
     * @ORM\ManyToMany(targetEntity="App\Model\Paseka\Entity\Matkas\Role\Role")
     * @ORM\JoinTable(name="paseka_matkas_plemmatka_uchastnik_roles",
     *     joinColumns={@ORM\JoinColumn(name="uchastnik_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="role_id", referencedColumnName="id")}
     * )
     */
    private $roles;

    /**
     * Uchastnik constructor.
     * @param PlemMatka $plemmatka
     * @param Uchastie $uchastie
     * @param ArrayCollection|Department[] $departments
     * @param ArrayCollection|Role[] $roles
     * @throws \Exception
     */
    public function __construct(PlemMatka $plemmatka, Uchastie $uchastie ,
                                array $departments, array $roles)
    {
        $this->guardDepartments($departments);
        $this->guardRoles($roles);

        $this->id = Uuid::uuid4()->toString();
        $this->plemmatka = $plemmatka;
        $this->uchastie = $uchastie;
        $this->departments = new ArrayCollection($departments);
        $this->roles = new ArrayCollection($roles);
    }
    /**
     * @param Department[] $departments
     */
    public function changeDepartments(array $departments): void
    {
        $this->guardDepartments($departments);

        $current = $this->departments->toArray();
        $new = $departments;

        $compare = static function (Department $a, Department $b): int {
            return $a->getId()->getValue() <=> $b->getId()->getValue();
        };

        foreach (array_udiff($current, $new, $compare) as $item) {
            $this->departments->removeElement($item);
        }

        foreach (array_udiff($new, $current, $compare) as $item) {
            $this->departments->add($item);
        }
    }

    /**
     * @param Role[] $roles
     */
    public function changeRoles(array $roles): void
    {
        $this->guardRoles($roles);

        $current = $this->roles->toArray();
        $new = $roles;

        $compare = static function (Role $a, Role $b): int {
            return $a->getId()->getValue() <=> $b->getId()->getValue();
        };

        foreach (array_udiff($current, $new, $compare) as $item) {
            $this->roles->removeElement($item);
        }

        foreach (array_udiff($new, $current, $compare) as $item) {
            $this->roles->add($item);
        }
    }

    public function isForUchastie(UchastieId $id): bool
    {
        return $this->uchastie->getId()->isEqual($id);
    }

    public function isForDepartment(DepartmentId $id): bool
    {
        foreach ($this->departments as $department) {
            if ($department->getId()->isEqual($id)) {
                return true;
            }
        }
        return false;
    }

    public function isGranted(string $permission): bool
    {
        foreach ($this->roles as $role) {
            if ($role->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }

    public function getUchastie(): Uchastie
    {
        return $this->uchastie;
    }

    /**
     * @return Role[]
     */
    public function getRoles(): array
    {
        return $this->roles->toArray();
    }

    /**
     * @return Department[]
     */
    public function getDepartments(): array
    {
        return $this->departments->toArray();
    }

    public function guardDepartments(array $departments): void
    {
        if (\count($departments) === 0) {
            throw new \DomainException('Set at least one department.');
        }
    }

    public function guardRoles(array $roles): void
    {
        if (\count($roles) === 0) {
            throw new \DomainException('Set at least one role.');
        }
    }
}