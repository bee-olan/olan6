<?php

declare(strict_types=1);

namespace App\ReadModel\Proekt\Pasekas\PlemMatka\Side\Filter;

use App\Model\Paseka\Entity\Uchasties\Uchastie\Status;

class Filter
{
    public $uchastie;
    public $name;
    public $persona;
    public $name_kateg;
    public $status = Status::ACTIVE;


    private function __construct(?string $uchastie)
    {
        $this->uchastie = $uchastie;
    }

    public static function all(): self
    {
        return new self(null);
    }

    public static function forUchastie(string $id): self
    {
        return new self($id);
    }
}