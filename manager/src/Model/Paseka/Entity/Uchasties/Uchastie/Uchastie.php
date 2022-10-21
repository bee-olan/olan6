<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Uchasties\Uchastie;

use App\Model\Paseka\Entity\Uchasties\Group\Group;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="paseka_uchasties_uchasties")
 */
class Uchastie
{
    /**
     * @var Id
     * @ORM\Column(type="paseka_uchasties_uchastie_id")
     * @ORM\Id
     */
    private $id;



    /**
     * @var Group
     * @ORM\ManyToOne(targetEntity="App\Model\Paseka\Entity\Uchasties\Group\Group")
     * @ORM\JoinColumn(name="group_id", referencedColumnName="id", nullable=false)
     */
    private $group;
    /**
     * @var Name
     * @ORM\Embedded(class="Name")
     */
    private $name;
    // /**
    //  * @var Email
    //  * @ORM\Column(type="paseka_uchasties_uchastie_email")
    //  */
    // private $email;
    ///**
    //  * @var Status
    //  * @ORM\Column(type="paseka_uchasties_uchastie_status", length=16)
    //  */
    // private $status;

    public function __construct(Id $id, Group $group, Name $name)
    {
        $this->id = $id;
        $this->group = $group;
        $this->name = $name;
        //$this->email = $email;
        //$this->status = Status::active();
    }

    public function edit(Name $name): void
    {
        $this->name = $name;
       // $this->email = $email;
    }

    public function move(Group $group): void
    {
        $this->group = $group;
    }

    public function archive(): void
    {
        if ($this->status->isArchived()) {
            throw new \DomainException('Uchastie is already archived.');
        }
        $this->status = Status::archived();
    }

    public function reinstate(): void
    {
        if ($this->status->isActive()) {
            throw new \DomainException('Uchastie is already active.');
        }
        $this->status = Status::active();
    }

    public function isActive(): bool
    {
        return $this->status->isActive();
    }

    public function isArchived(): bool
    {
        return $this->status->isArchived();
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getGroup(): Group
    {
        return $this->group;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    // public function getEmail(): Email
    // {
    //     return $this->email;
    // }

    // public function getStatus(): Status
    // {
    //     return $this->status;
    // }

    // public function __toString(): string
    // {
    //     return $this->value;
    // }
}