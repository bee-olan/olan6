<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\PlemMatka\Uchastnik\Edit;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatkaRepository;
use App\Model\Paseka\Entity\Matkas\PlemMatka\Id;
use App\Model\Paseka\Entity\Matkas\Role\Role;
use App\Model\Paseka\Entity\Matkas\Role\Id as RoleId;
use App\Model\Paseka\Entity\Matkas\Role\RoleRepository;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Id as UchastieId;
use App\Model\Paseka\Entity\Uchasties\Uchastie\UchastieRepository;
use App\Model\Paseka\Entity\Matkas\PlemMatka\Department\Id as DepartmentId;


class Handler
{
    private $plemmatkas;
    private $uchasties;
    private $roles;
    private $flusher;

    public function __construct(
        PlemMatkaRepository $plemmatkas,
        UchastieRepository $uchasties,
        RoleRepository $roles,
        Flusher $flusher
    )
    {
        $this->plemmatkas = $plemmatkas;
        $this->uchasties = $uchasties;
        $this->roles = $roles;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $plemmatka = $this->plemmatkas->get(new Id($command->plemmatka)) ;
        $uchastie = $this->uchasties->get(new UchastieId($command->uchastie));

        $departments = array_map(static function (string $id): DepartmentId {
            return new DepartmentId($id);
        }, $command->departments);

        $roles = array_map(function (string $id): Role {
            return $this->roles->get(new RoleId($id));
        }, $command->roles);

        $plemmatka->editUchastie($uchastie->getId(), $departments, $roles);

        $this->flusher->flush();
    }
}

