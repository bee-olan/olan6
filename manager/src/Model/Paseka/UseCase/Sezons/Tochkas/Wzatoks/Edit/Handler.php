<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Sezons\Tochkas\Wzatoks\Edit;

use App\Model\Flusher;
//use App\Model\Paseka\Entity\Sxemas\Id;
//use App\Model\Paseka\Entity\Sxemas\SxemaRepository;

class Handler
{
    private $sxemas;
    private $flusher;

    public function __construct(SxemaRepository $sxemas, Flusher $flusher)
    {
        $this->sxemas = $sxemas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $sxema = $this->sxemas->get(new Id($command->id));

        $sxema->edit($command->name, $command->title);

        $this->flusher->flush();
    }
}
