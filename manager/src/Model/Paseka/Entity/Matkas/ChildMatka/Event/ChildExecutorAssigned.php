<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Matkas\ChildMatka\Event;

use App\Model\Paseka\Entity\Matkas\ChildMatka\Id;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Id as UchastieId;

class ChildExecutorAssigned
{
    public $actorId;
    public $childmatkaId;
    public $executorId;

    public function __construct(UchastieId $actorId, Id $childmatkaId, UchastieId $executorId)
    {
        $this->actorId = $actorId;
        $this->childmatkaId = $childmatkaId;
        $this->executorId = $executorId;
    }
}
