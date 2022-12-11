<?php

declare(strict_types=1);

namespace App\ReadModel\Proekt\Pasekas\Uchasties\Side\Filter;

use App\Model\Paseka\Entity\Uchasties\Uchastie\Status;

class Filter
{
    public $name;
    // public $email;
    public $group;
    public $status = Status::ACTIVE;
    public $uchkak;
}
