<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\ChildMatkas;

use App\Model\Paseka\Entity\Uchasties\Uchastie\Uchastie;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\ChildOf;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Edit;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Executor;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Move;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Plan;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Priority;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Progress;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Remove;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Start;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Status;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Take;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\TakeAndStart;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Type;


use App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatka;
use App\ReadModel\Paseka\Matkas\ChildMatka\ChildMatkaFetcher;

use App\ReadModel\Paseka\Uchasties\Uchastie\UchastieFetcher;

//use App\Model\Work\Entity\Projects\Project\Project;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Create;
//use App\Model\Work\UseCase\Projects\Task\Executor;
//use App\Model\Work\UseCase\Projects\Task\Plan;
use App\ReadModel\Proekt\Pasekas\ChildMatka\Side\Filter;
use App\ReadModel\Proekt\Pasekas\ChildMatka\Side\ChildSideFetcher;
//use App\Security\Voter\Work\Projects\ProjectAccess;
use App\Controller\ErrorHandler;
use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatka;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("proekt/pasekas/childmatkas", name="proekt.pasekas.childmatkas")
 * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
 */
class ChildShowController extends AbstractController
{
    private const PER_PAGE = 50;

    private $errors;

    public function __construct( ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
     * @Route("/{id}", name=".show", requirements={"id"="\d+"}))
     * @param ChildMatka $childmatka
     * @param Request $request
     * @param UchastieFetcher $uchasties
     * @param ChildMatkaFetcher $childmatkas
     * @param Status\Handler $statusHandler
     * @param Progress\Handler $progressHandler
     * @param Type\Handler $typeHandler
     * @param Priority\Handler $priorityHandler
     * @return Response
     */
    public function show(
        ChildMatka $childmatka,
        Request $request,
        UchastieFetcher $uchasties,
        ChildMatkaFetcher $childmatkas,
        Status\Handler $statusHandler,
        Progress\Handler $progressHandler,
        Type\Handler $typeHandler,
        Priority\Handler $priorityHandler
    ): Response
    {
      //  $this->denyAccessUnlessGranted(TaskAccess::VIEW, $task);

        if (!$uchastie = $uchasties->find($this->getUser()->getId())) {
            throw $this->createAccessDeniedException();
        }

        $statusCommand = Status\Command::fromChildMatka($childmatka);
        $statusForm = $this->createForm(Status\Form::class, $statusCommand);
        $statusForm->handleRequest($request);
        if ($statusForm->isSubmitted() && $statusForm->isValid()) {
            try {
                $statusHandler->handle($statusCommand);
                return $this->redirectToRoute('paseka.matkas.childmatkas.show', ['id' => $childmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        $progressCommand = Progress\Command::fromTask($childmatka);
        $progressForm = $this->createForm(Progress\Form::class, $progressCommand);
        $progressForm->handleRequest($request);
        if ($progressForm->isSubmitted() && $progressForm->isValid()) {
            try {
                $progressHandler->handle($progressCommand);
                return $this->redirectToRoute('paseka.matkas.childmatkas.show', ['id' => $childmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        $typeCommand = Type\Command::fromChildMatka($childmatka);
        $typeForm = $this->createForm(Type\Form::class, $typeCommand);
        $typeForm->handleRequest($request);
        if ($typeForm->isSubmitted() && $typeForm->isValid()) {
            try {
                $typeHandler->handle($typeCommand);
                return $this->redirectToRoute('paseka.matkas.childmatkas.show', ['id' => $childmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        $priorityCommand = Priority\Command::fromChildMatka($childmatka);
        $priorityForm = $this->createForm(Priority\Form::class, $priorityCommand);
        $priorityForm->handleRequest($request);
        if ($priorityForm->isSubmitted() && $priorityForm->isValid()) {
            try {
                $priorityHandler->handle($priorityCommand);
                return $this->redirectToRoute('paseka.matkas.childmatkas.show', ['id' => $childmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('proekt/pasekas/childmatkas/show.html.twig', [
            'plemmatka' => $childmatka->getPlemMatka(),
            'childmatka' => $childmatka,
            'uchastie' => $uchastie,
            'children' => $childmatkas->childrenOf($childmatka->getId()->getValue()),
            'statusForm' => $statusForm->createView(),
            'progressForm' => $progressForm->createView(),
            'typeForm' => $typeForm->createView(),
            'priorityForm' => $priorityForm->createView(),
        ]);
    }

}
