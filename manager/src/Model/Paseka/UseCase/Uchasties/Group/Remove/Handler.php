<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Uchasties\Group\Remove;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Uchasties\Group\GroupRepository;
use App\Model\Paseka\Entity\Uchasties\Group\Id;


class Handler
{
    private $groups;
    private $flusher;

    public function __construct(GroupRepository $groups,                               
                                Flusher $flusher)
    {
        $this->groups = $groups;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $group = $this->groups->get(new Id($command->id));

        // if ($this->Uchasties->hasByGroup($group->getId())) {
        //     throw new \DomainException('Group is not empty.');
        // }


        $this->groups->remove($group);

        $this->flusher->flush();
    }
}
