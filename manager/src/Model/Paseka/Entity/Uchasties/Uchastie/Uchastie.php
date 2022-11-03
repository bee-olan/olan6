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
     * @var \DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private $date;

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
     /**
      * @var Email
      * @ORM\Column(type="paseka_uchasties_uchastie_email")
      */
     private $email;
    /**
      * @var Status
      * @ORM\Column(type="paseka_uchasties_uchastie_status", length=16)
      */
     private $status;

    /**
     * @var UchKak
     * @ORM\Column(type="paseka_uchasties_uchastie_uchkak", name="uchkak", length=16)
     */
    private $uchkak;

    public function __construct(Id $id, \DateTimeImmutable $date,
                                Group $group,
                                Name $name, Email $email
                               )
    {
        $this->id = $id;
        $this->date = $date;
        $this->group = $group;
        $this->name = $name;
        $this->email = $email;
        $this->status = Status::active();
        $this->uchkak = UchKak::nablud();
    }

    public function edit(Name $name, Email $email): void
    {
        $this->name = $name;
        $this->email = $email;
    }

//изменить учкак
    public function changeUchKak(UchKak $uchkak): void
    {
        if ($this->uchkak->isEqual($uchkak)) {
            throw new \DomainException('Вы так и участвуете.');
        }
        $this->uchkak = $uchkak;
    }

    public function move(Group $group): void
    {
        $this->group = $group;
    }

    public function archive(): void
    {
        if ($this->status->isArchived()) {
            throw new \DomainException('Участие уже заархивировано.');
        }
        $this->status = Status::archived();
    }

    public function reinstate(): void
    {
        if ($this->status->isActive()) {
            throw new \DomainException('Участие уже активно.');
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

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getGroup(): Group
    {
        return $this->group;
    }

    public function getName(): Name
    {
        return $this->name;
    }

     public function getEmail(): Email
     {
         return $this->email;
     }

     public function getStatus(): Status
     {
         return $this->status;
     }

    public function getUchkak(): UchKak
    {
        return $this->uchkak;
    }

}
