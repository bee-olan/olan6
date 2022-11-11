<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Matkas;

// use App\Model\Work\Entity\Members\Member\Member;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Task;
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
use App\ReadModel\Paseka\Matkas\ChildMatka\Filter;
use App\ReadModel\Paseka\Matkas\ChildMatka\ChildMatkaFetcher;

use App\ReadModel\Paseka\Uchasties\Uchastie\UchastieFetcher;
use App\ReadModel\Paseka\Uchasties\Uchastie\Uchastie;

use App\Controller\ErrorHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/paseka/matkas/childmatkas", name="paseka.matkas.childmatkas")
 * @param Request $request
 * @param ChildMatkaFetcher $childmatkas
 * @return Response
 */
class ChildMatkasController extends AbstractController
{
    private const PER_PAGE = 50;

    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("", name="")
     * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
     * @param Request $request
     * @param ChildMatkaFetcher $childmatkas
     * @return Response
     */
    public function index(Request $request, ChildMatkaFetcher $childmatkas): Response
    {
        // if ($this->isGranted('ROLE_WORK_MANAGE_PROJECTS')) {
             $filter = Filter\Filter::all();
        // } else {
         //   $filter = Filter\Filter::all()->forUchastie($this->getUser()->getId());
       // }
//dd($filter);
        $form = $this->createForm(Filter\Form::class, $filter);
        $form->handleRequest($request);

        $pagination = $childmatkas->all(
            $filter,
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort', 't.id'),
            $request->query->get('direction', 'desc')
        );

        return $this->render('app/paseka/matkas/childmatkas/index.html.twig', [
            'plemmatka' => null,
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     * @param ChildMatka $childmatka
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(ChildMatka $childmatka, Request $request, Edit\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(TaskAccess::MANAGE, $task);

        $command = Edit\Command::fromChildMatka($this->getUser()->getId(), $childmatka);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('paseka.matkas.childmatkas.show', ['id' => $childmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/matkas/childmatkas/edit.html.twig', [
            'plemmatka' => $childmatka->getPlemMatka(),
            'childmatka' => $childmatka,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/assign", name=".assign")
     * @param ChildMatka $childmatka
     * @param Request $request
     * @param Executor\Assign\Handler $handler
     * @return Response
     */
    public function assign(ChildMatka $childmatka, Request $request, Executor\Assign\Handler $handler): Response
    {
        $plemmatka = $childmatka->getPlemMatka();
       // $this->denyAccessUnlessGranted(TaskAccess::MANAGE, $task);

        $command = new Executor\Assign\Command($this->getUser()->getId(), $childmatka->getId()->getValue());

        $form = $this->createForm(Executor\Assign\Form::class, $command, ['$plemmatka_id' => $plemmatka->getId()->getValue()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('paseka.matkas.childmatkas.show', ['id' => $childmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/matkas/childmatkas/assign.html.twig', [
            'plemmatka' => $plemmatka,
            'childmatka' => $childmatka,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/take", name=".take", methods={"POST"})
     * @param ChildMatka $childmatka
     * @param Request $request
     * @param Take\Handler $handler
     * @return Response
     */
    public function take(ChildMatka $childmatka, Request $request, Take\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('take', $request->request->get('token'))) {
            return $this->redirectToRoute('paseka.matkas.childmatkas.show', ['id' => $childmatka->getId()]);
        }

//        $this->denyAccessUnlessGranted(TaskAccess::MANAGE, $task);

        $command = new Take\Command($this->getUser()->getId(), $childmatka->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('paseka.matkas.childmatkas.show', ['id' => $childmatka->getId()]);
    }

    /**
     * @Route("/{id}/take/start", name=".take_and_start", methods={"POST"})
     * @param ChildMatka $childmatka
     * @param Request $request
     * @param TakeAndStart\Handler $handler
     * @return Response
     */
    public function takeAndStart(ChildMatka $childmatka, Request $request, TakeAndStart\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('take-and-start', $request->request->get('token'))) {
            return $this->redirectToRoute('paseka.matkas.childmatkas.show', ['id' => $childmatka->getId()]);
        }

        //$this->denyAccessUnlessGranted(TaskAccess::MANAGE, $task);

        $command = new TakeAndStart\Command($this->getUser()->getId(), $childmatka->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('paseka.matkas.childmatkas.show', ['id' => $childmatka->getId()]);
    }

    /**
     * @Route("/{id}/start", name=".start", methods={"POST"})
     * @param ChildMatka $childmatka
     * @param Request $request
     * @param Start\Handler $handler
     * @return Response
     */
    public function start(ChildMatka $childmatka, Request $request, Start\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('start', $request->request->get('token'))) {
            return $this->redirectToRoute('paseka.matkas.childmatkas.show', ['id' => $childmatka->getId()]);
        }

        //$this->denyAccessUnlessGranted(TaskAccess::MANAGE, $task);

        $command = new Start\Command($this->getUser()->getId(), $childmatka->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('paseka.matkas.childmatkas.show', ['id' => $childmatka->getId()]);
    }

    /**
     * @Route("/{id}/move", name=".move")
     * @param ChildMatka $childmatka
     * @param Request $request
     * @param Move\Handler $handler
     * @return Response
     */
    public function move(ChildMatka $childmatka, Request $request, Move\Handler $handler): Response
    {
       // $this->denyAccessUnlessGranted(TaskAccess::MANAGE, $task);

        $command = Move\Command::fromChildMatka($this->getUser()->getId(), $childmatka);

        $form = $this->createForm(Move\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('paseka.matkas.childmatkas.show', ['id' => $childmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/work/projects/tasks/move.html.twig', [
            'plemmatka' => $childmatka->getPlemMatka(),
            'childmatka' => $childmatka,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/plan", name=".plan")
     * @param ChildMatka $childmatka
     * @param Request $request
     * @param Plan\Set\Handler $handler
     * @return Response
     */
    public function plan(ChildMatka $childmatka, Request $request, Plan\Set\Handler $handler): Response
    {
       // $this->denyAccessUnlessGranted(TaskAccess::MANAGE, $task);

        $command = Plan\Set\Command::fromChildMatka($this->getUser()->getId(), $childmatka);

        $form = $this->createForm(Plan\Set\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('paseka.matkas.childmatkas.show', ['id' => $childmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/matkas/childmatkas/plan.html.twig', [
            'plemmatka' => $childmatka->getPlemMatka(),
            'childmatka' => $childmatka,
            'form' => $form->createView(),
        ]);
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

        return $this->render('app/paseka/matkas/childmatkas/show.html.twig', [
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
