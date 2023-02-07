<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Matkas\ChildMatka\Event;

//use App\Model\Work\Entity\Members\Member\Id as MemberId;
//use App\Model\Work\Entity\Projects\Task\Id;

use App\Model\Paseka\Entity\Matkas\ChildMatka\Id;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Id as UchastieId;

class TaskExecutorAssigned
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
