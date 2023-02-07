<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Matkas\ChildMatka\Event;

//use App\Model\Work\Entity\Members\Member\Id as MemberId;
//use App\Model\Work\Entity\Projects\Task\Id;

class TaskProgressChanged
{
    public $actorId;
    public $taskId;
    public $progress;

    public function __construct(MemberId $actorId, Id $taskId, int $progress)
    {
        $this->actorId = $actorId;
        $this->taskId = $taskId;
        $this->progress = $progress;
    }
}
