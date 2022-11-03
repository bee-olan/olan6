<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Uchasties\Uchastie\Create;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Uchasties\Group\GroupRepository;
use App\Model\Paseka\Entity\Uchasties\Group\Id as GroupId;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Email;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Uchastie;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Id;
use App\Model\Paseka\Entity\Uchasties\Uchastie\UchastieRepository;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Name;

class Handler
{
    private $uchasties;
    private $groups;
    private $flusher;

    public function __construct(UchastieRepository $uchasties, GroupRepository $groups, Flusher $flusher)
    {
        $this->uchasties = $uchasties;
        $this->groups = $groups;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {

        $id = new Id($command->id);

        if ($this->uchasties->has($id)) {
            throw new \DomainException('Uchastie уже существует !!.');
        }
        //$command->email = 'user@app.test';
        $group = $this->groups->get(new GroupId($command->group));

        $uchastie = new Uchastie(
            $id,
            new \DateTimeImmutable(),
            $group,
            new Name(
                $command->firstName,
                $command->lastName,
                $command->nikeName
            ),
            new Email($command->email)
        );


        $this->uchasties->add($uchastie);

        $this->flusher->flush();
    }
}

