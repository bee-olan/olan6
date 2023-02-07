<?php

declare(strict_types=1);

namespace App\Event\Listener\Paseka\Matkas\ChildMatka;

use App\Model\Work\Entity\Projects\Task\Event\TaskFileRemoved;
use App\Service\Uploader\FileUploader;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class FileRemoveSubscriber implements EventSubscriberInterface
{
    private $uploader;

    public function __construct(FileUploader $uploader)
    {
        $this->uploader = $uploader;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            TaskFileRemoved::class => 'onTaskFileRemoved',
        ];
    }

    public function onTaskFileRemoved(TaskFileRemoved $event): void
    {
        $this->uploader->remove($event->info->getPath(), $event->info->getName());
    }
}