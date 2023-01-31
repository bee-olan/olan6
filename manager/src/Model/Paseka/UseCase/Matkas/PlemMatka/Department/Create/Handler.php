<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\PlemMatka\Department\Create;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Matkas\PlemMatka\Department\Id;
use App\Model\Paseka\Entity\Matkas\PlemMatka\Id as PlemMatkaId;
use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatkaRepository;
use App\ReadModel\Paseka\Matkas\PlemMatka\DepartmentFetcher;

class Handler
{
    private $plemmatkas;
    private $departments;
    private $flusher;

    public function __construct(DepartmentFetcher $departments, PlemMatkaRepository $plemmatkas, Flusher $flusher)
    {
        $this->plemmatkas = $plemmatkas;
        $this->departments = $departments;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $plemmatka = $this->plemmatkas->get(new PlemMatkaId($command->plemmatka));

        $nach = $plemmatka->getGodaVixod()+ count($plemmatka->getDepartments());

            $command->name = $nach." - ".($nach +1);
            $plemmatka->addDepartment(
                Id::next(),
                $command->name
            );


        $this->flusher->flush();
    }
}
