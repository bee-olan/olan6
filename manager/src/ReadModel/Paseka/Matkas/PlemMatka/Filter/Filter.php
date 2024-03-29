<?php

declare(strict_types=1);

namespace App\ReadModel\Paseka\Matkas\PlemMatka\Filter;

use App\Model\Paseka\Entity\Uchasties\Uchastie\Status;

class Filter
{
    public $name;
    public $persona;
    public $status = Status::ACTIVE;
    public $god_vixod;
}