<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Matkas\ChildMatka;

use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatka;

use App\Model\Paseka\Entity\Uchasties\Uchastie\Uchastie;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Id as UchastieId;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Webmozart\Assert\Assert;

/**
 * @ORM\Entity()
 * @ORM\Table(name="paseka_matkas_childmatkas", indexes={
 *     @ORM\Index(columns={"date"})
 * })
 */
class ChildMatka
{
    /**
     * @var Id
     * @ORM\Column(type="paseka_matkas_childmatka_id")
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\SequenceGenerator(sequenceName="paseka_matkas_childmatkas_seq", initialValue=1)
     * @ORM\Id
     */
    private $id;

    /**
     * @var PlemMatka
     * @ORM\ManyToOne(targetEntity="App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatka")
     * @ORM\JoinColumn(name="plemmatka_id", referencedColumnName="id", nullable=false)
     */
    private $plemmatka;

    /**
     * @var Uchastie
     * @ORM\ManyToOne(targetEntity="App\Model\Paseka\Entity\Uchasties\Uchastie\Uchastie")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id", nullable=false)
     */
    private $author;

    /**
     * @var \DateTimeImmutable
     * @ORM\Column(type="datetime_immutable")
     */
    private $date;

    /**
     * @var \DateTimeImmutable|null
     * @ORM\Column(type="date_immutable", nullable=true)
     */   
    private $planDate;

    /**
     * @var \DateTimeImmutable|null
     * @ORM\Column(type="date_immutable", nullable=true)
     */
    private $startDate;

    /**
     * @var \DateTimeImmutable|null
     * @ORM\Column(type="date_immutable", nullable=true)
     */
    private $endDate;

    /**
     * @var string
     * @ORM\Column(type="string")
     */    
    private $name;

    /**
     * @var string
     * @ORM\Column(type="text", nullable=true)
     */    
    private $content;

    /**
     * @var Type
     * @ORM\Column(type="paseka_matkas_childmatka_type", length=16)
     */    
    private $type;

    /**
     * @ORM\Column(type="smallint") 
     */
    private $progress;  // smallint - маленький int

    /**
     * @ORM\Column(type="smallint")
     */    
    private $priority;

    /**
     * @var ChildMatka|null
     * @ORM\ManyToOne(targetEntity="ChildMatka")
     * @ORM\JoinColumn(name="parent_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */    
    private $parent;  // родитель

    /**
     * @var Status
     * @ORM\Column(type="paseka_matkas_childmatka_status", length=16)
     */    
    private $status;

     /**
     * @var Uchastie[]|ArrayCollection
     * @ORM\ManyToMany(targetEntity="App\Model\Paseka\Entity\Uchasties\Uchastie\Uchastie")
     * @ORM\JoinTable(name="paseka_matkas_childmatkas_executors",
     *      joinColumns={@ORM\JoinColumn(name="childmatka_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="uchastie_id", referencedColumnName="id")}
     * )
     * @ORM\OrderBy({"name.first" = "ASC"})
     */   
    private $executors; // экзекутор - исполнитель

    public function __construct(
        Id $id,
        PlemMatka $plemmatka,
        Uchastie $author,
        \DateTimeImmutable $date,
        Type $type,
        int $priority,
        string $name,
        ?string $content
    )
    {
        $this->id = $id;
        $this->plemmatka = $plemmatka;
        $this->author = $author;
        $this->date = $date;
        $this->name = $name;
        $this->content = $content;
        $this->progress = 0;
        $this->type = $type;
        $this->priority = $priority;
        $this->status = Status::new();
        $this->executors = new ArrayCollection();
    }

    public function edit( ?string $content): void
    {

        $this->content = $content;
    }

    public function start(\DateTimeImmutable $date): void
    {
        if (!$this->isNew()) {
            throw new \DomainException('Task is already started.');
        }
        if (!$this->executors->count()) {
            throw new \DomainException('Task does not contain executors.');
        }
        $this->changeStatus(Status::working(), $date);
    }

    public function setChildOf(?ChildMatka $parent): void
    {
        if ($parent) {
            $current = $parent;
            do {
                if ($current === $this) {
                    throw new \DomainException('Цикломатические дети.');
                }
            }
            while ($current && $current = $current->getParent());
        }

        $this->parent = $parent;
    }

    public function plan(?\DateTimeImmutable $date): void
    {
        $this->planDate = $date;
    }
// переместить
    public function move(PlemMatka $plemmatka): void
    {
        if ($plemmatka === $this->plemmatka) {
            throw new \DomainException('PlemMatka это уже то же самое.');
        }
        $this->plemmatka = $plemmatka;
    }

//изменить тип
    public function changeType(Type $type): void
    {
        if ($this->type->isEqual($type)) {
            throw new \DomainException('Тип уже тот же самый.');
        }
        $this->type = $type;
    }

    public function changeStatus(Status $status, \DateTimeImmutable $date): void
    {
        if ($this->status->isEqual($status)) {
            throw new \DomainException('Status is already same.');
        }
        $this->status = $status;
        if (!$status->isNew() && !$this->startDate) {
            $this->startDate = $date;
        }
        if ($status->isDone()) {
            if ($this->progress !== 100) {
                $this->changeProgress(100);
            }
            $this->endDate = $date;
        } else {
            $this->endDate = null;
        }
    }

    public function changeProgress(int $progress): void
    {
        Assert::range($progress, 0, 100);
        if ($progress === $this->progress) {
            throw new \DomainException('Прогресс уже такой же.');
        }
        $this->progress = $progress;
    }

    public function changePriority(int $priority): void
    {
        Assert::range($priority, 1, 4);
        if ($priority === $this->priority) {
            throw new \DomainException('Priority is already same.');
        }
        $this->priority = $priority;
    }

    public function hasExecutor(UchastieId $id): bool
    {
        foreach ($this->executors as $executor) {
            if ($executor->getId()->isEqual($id)) {
                return true;
            }
        }
        return false;
    }

    public function assignExecutor(Uchastie $executor): void
    {
        if ($this->executors->contains($executor)) {
            throw new \DomainException('Executor is already assigned.');
        }
        $this->executors->add($executor);
    }

    public function revokeExecutor(UchastieId $id): void
    {
        foreach ($this->executors as $current) {
            if ($current->getId()->isEqual($id)) {
                $this->executors->removeElement($current);
                return;
            }
        }
        throw new \DomainException('Executor is not assigned.');
    }

    public function isNew(): bool
    {
        return $this->status->isNew();
    }

    public function isWorking(): bool
    {
        return $this->status->isWorking();
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getPlemMatka(): PlemMatka
    {
        return $this->plemmatka;
    }

    public function getAuthor(): Uchastie
    {
        return $this->author;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getPlanDate(): ?\DateTimeImmutable
    {
        return $this->planDate;
    }

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function getType(): Type
    {
        return $this->type;
    }

    public function getProgress(): int
    {
        return $this->progress;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function getParent(): ?PlemMatka
    {
        return $this->parent;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * @return Uchastie[]
     */
    public function getExecutors(): array
    {
        return $this->executors->toArray();
    }
}
