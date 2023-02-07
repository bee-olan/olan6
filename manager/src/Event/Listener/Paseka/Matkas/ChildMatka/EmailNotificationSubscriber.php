<?php

declare(strict_types=1);

namespace App\Event\Listener\Paseka\Matkas\ChildMatka;

use App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatkaRepository;
use App\Model\Paseka\Entity\Matkas\ChildMatka\Event\ChildExecutorAssigned;
use App\Model\Paseka\Entity\Uchasties\Uchastie\UchastieRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Twig\Environment;

class EmailNotificationSubscriber implements EventSubscriberInterface
{
    private $childmatkas;
    private $uchasties;
    private $mailer;
    private $twig;

    public function __construct(ChildMatkaRepository $childmatkas, UchastieRepository $uchasties, \Swift_Mailer $mailer, Environment $twig)
    {
        $this->childmatkas = $childmatkas;
        $this->uchasties = $uchasties;
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ChildExecutorAssigned::class => [
                ['onChildMatkaExecutorAssignedExecutor'],
                ['onChildMatkaExecutorAssignedAuthor']
            ],
        ];
    }

    public function onChildMatkaExecutorAssignedExecutor(ChildExecutorAssigned $event): void
    {
        if ($event->executorId->isEqual($event->actorId)) {
            return;
        }

        $childmatka = $this->childmatkas->get($event->childmatkaId);
        $executor = $this->uchasties->get($event->executorId);
        $author = $childmatka->getAuthor();

        if ($executor === $author) {
            return;
        }

        $message = (new \Swift_Message('ChildMatka Executor Assignment'))
            ->setTo([$executor->getEmail()->getValue() => $executor->getName()->getFull()])
            ->setBody($this->twig->render('mail/work/projects/childmatka/executor-assigned-executor.html.twig', [
                'childmatka' => $childmatka,
                'executor' => $executor,
            ]), 'text/html');

        if (!$this->mailer->send($message)) {
            throw new \RuntimeException('Unable to send message.');
        }
    }

    public function onChildMatkaExecutorAssignedAuthor(ChildExecutorAssigned $event): void
    {
        $childmatka = $this->childmatkas->get($event->childmatkaId);
        $executor = $this->uchasties->get($event->executorId);
        $author = $childmatka->getAuthor();

        if ($executor === $author) {
            return;
        }

        $message = (new \Swift_Message('Your ChildMatka Executor Assignment'))
            ->setTo([$author->getEmail()->getValue() => $author->getName()->getFull()])
            ->setBody($this->twig->render('mail/work/projects/childmatka/executor-assigned-author.html.twig', [
                'childmatka' => $childmatka,
                'author' => $author,
                'executor' => $executor,
            ]), 'text/html');

        if (!$this->mailer->send($message)) {
            throw new \RuntimeException('Unable to send message.');
        }
    }
}
