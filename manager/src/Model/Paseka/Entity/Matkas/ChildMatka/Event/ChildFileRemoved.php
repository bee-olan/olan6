<?php

declare(strict_types=1);

namespace App\Model\Paseka\Entity\Matkas\ChildMatka\Event;

use App\Model\Paseka\Entity\Matkas\ChildMatka\Id;
use App\Model\Paseka\Entity\Matkas\ChildMatka\File\Id as FileId;
use App\Model\Paseka\Entity\Matkas\ChildMatka\File\Info;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Id as UchastieId;

class ChildFileRemoved
{
    public $actorId;
    public $childmatkaId;
    public $fileId;
    public $info;

    public function __construct(UchastieId $actorId, Id $childmatkaId, FileId $fileId, Info $info)
    {
        $this->actorId = $actorId;
        $this->childmatkaId = $childmatkaId;
        $this->fileId = $fileId;
        $this->info = $info;
    }
}
