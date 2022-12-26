<?php

declare(strict_types=1);

namespace App\ReadModel\Proekt\Pasekas\PlemMatka\Side\Filter;

use App\Model\Paseka\Entity\Uchasties\Uchastie\Status;

class Filter
{
    public $name;
    public $persona;
    public $name_kateg;
    public $status = Status::ACTIVE;
}