<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\PlemMatka\Department\Remove;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Matkas\PlemMatka\Department\Id as DepartmentId;
use App\Model\Paseka\Entity\Matkas\PlemMatka\Id;
use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatka;
use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatkaRepository;

class Handler
{
    private $plemmatkas;
    private $flusher;

    public function __construct(PlemMatkaRepository $plemmatkas, Flusher $flusher)
    {
        $this->plemmatkas = $plemmatkas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $plemmatka = $this->plemmatkas->get(new Id($command->plemmatka));

        $plemmatka->removeDepartment(new DepartmentId($command->id));

        $this->flusher->flush();
    }
}

