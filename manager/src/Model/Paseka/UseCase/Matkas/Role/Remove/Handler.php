<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\Role\Remove;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatkaRepository;
use App\Model\Paseka\Entity\Matkas\Role\RoleRepository;
use App\Model\Paseka\Entity\Matkas\Role\Id;

class Handler
{
    private $roles;
    private $plemmatkas;
    private $flusher;

    public function __construct(RoleRepository $roles, PlemMatkaRepository $plemmatkas, Flusher $flusher)
    {

        $this->roles = $roles;
        $this->plemmatkas = $plemmatkas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $role = $this->roles->get(new Id($command->id));

        if ($this->plemmatkas->hasUchastiesWithRole($role->getId())) {
            throw new \DomainException('Роль содержит участников.');
        }

        $this->roles->remove($role);

        $this->flusher->flush();
    }
}
