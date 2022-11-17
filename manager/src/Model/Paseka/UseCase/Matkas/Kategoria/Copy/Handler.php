<?php

declare(strict_types=1);

namespace App\Model\Paseka\UseCase\Matkas\Kategoria\Copy;

use App\Model\Flusher;
use App\Model\Paseka\Entity\Matkas\Kategoria\Id;
use App\Model\Paseka\Entity\Matkas\Kategoria\KategoriaRepository;

class Handler
{
    private $kategorias;
    private $flusher;

    public function __construct(KategoriaRepository $kategorias, Flusher $flusher)
    {
        $this->kategorias = $kategorias;
        $this->flusher = $flusher;
    }

    public function handle(Command $command): void
    {
        $current = $this->kategorias->get(new Id($command->id));

        if ($this->kategorias->hasByName($command->name)) {
            throw new \DomainException('Kategoria already exists.');
        }

        $kategoria = $current->clone(
            Id::next(),
            $command->name
        );

        $this->kategorias->add($kategoria);

        $this->flusher->flush();
    }
}
