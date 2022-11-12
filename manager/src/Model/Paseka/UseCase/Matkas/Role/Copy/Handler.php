<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\Role\Copy;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Matkas\Role\Id;
use App\Model\Paseka\Entity\Matkas\Role\RoleRepository;

class Handler
{
    private $roles;
    private $flusher;

    public function __construct(RoleRepository $roles, Flusher $flusher)
    {
        $this->roles = $roles;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $current = $this->roles->get(new Id($command->id));

        if ($this->roles->hasByName($command->name)) {
            throw new \DomainException('Role already exists.');
        }

        $role = $current->clone(
            Id::next(),
            $command->name
        );

        $this->roles->add($role);

        $this->flusher->flush();
    }
}
