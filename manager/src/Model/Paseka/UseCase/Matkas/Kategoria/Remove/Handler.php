<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\Kategoria\Remove;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatkaRepository;
use App\Model\Paseka\Entity\Matkas\Kategoria\KategoriaRepository;
use App\Model\Paseka\Entity\Matkas\Kategoria\Id;

class Handler
{
    private $kategorias;
    private $plemmatkas;
    private $flusher;

    public function __construct(KategoriaRepository $kategorias, PlemMatkaRepository $plemmatkas, Flusher $flusher)
    {

        $this->kategorias = $kategorias;
        $this->plemmatkas = $plemmatkas;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $kategoria = $this->kategorias->get(new Id($command->id));

//        if ($this->plemmatkas->hasUchastiesWithKategoria($kategoria->getId())) {
//            throw new \DomainException('Роль содержит участников.');
//        }

        $this->kategorias->remove($kategoria);

        $this->flusher->flush();
    }
}
