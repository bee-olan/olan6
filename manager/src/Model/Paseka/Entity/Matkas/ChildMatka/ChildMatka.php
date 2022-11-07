<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Matkas\ChildMatka;

use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatka;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Uchastie;


class ChildMatka
{
    private $id;
    private $plemmatka;
    private $author;
    private $date;
    private $planDate;
    private $name;
    private $content;
    private $type;
    private $progress;
    private $priority;
    private $parent;  // родитель
    private $status;

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
    }

    public function edit(string $name, ?string $content): void
    {
        $this->name = $name;
        $this->content = $content;
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

    public function changeStatus(Status $status): void
    {
        if ($this->status->isEqual($status)) {
            throw new \DomainException('Status is already same.');
        }
        $this->status = $status;
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



    public function isNew(): bool
    {
        return $this->status->isNew();
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
}
