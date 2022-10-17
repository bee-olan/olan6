<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Uchasties\Group\Create;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Uchasties\Group\Group;
use App\Model\Paseka\Entity\Uchasties\Group\Id;
use App\Model\Paseka\Entity\Uchasties\Group\GroupRepository;

class Handler
{
    private $groups;
    private $flusher;

    public function __construct(GroupRepository $groups, Flusher $flusher)
    {
        $this->groups = $groups;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $group = new Group(
            Id::next(),
            $command->name
//            ,
//            $command->title
        );

        $this->groups->add($group);

        $this->flusher->flush();
    }
}
