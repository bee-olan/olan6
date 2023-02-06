<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Matkas;

// use App\Model\Work\Entity\Members\Member\Member;

use App\Model\Comment\UseCase\Comment;
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
use App\ReadModel\Paseka\Matkas\ActionFetcher;
use App\ReadModel\Paseka\Matkas\ChildMatka\CommentFetcher;
use App\ReadModel\Paseka\Matkas\ChildMatka\Filter;
use App\ReadModel\Paseka\Matkas\ChildMatka\ChildMatkaFetcher;

use App\ReadModel\Paseka\Uchasties\Uchastie\UchastieFetcher;


use App\Controller\ErrorHandler;
use App\Security\Voter\Proekt\Matkas\ChildMatkaAccess;
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
        //$this->denyAccessUnlessGranted(ChildMatkaAccess::MANAGE, $childmatka);

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
     * @Route("/{id}/child", name=".child")
     * @param ChildMatka $childmatka
     * @param Request $request
     * @param ChildOf\Handler $handler
     * @return Response
     */
    public function childOf(ChildMatka $childmatka, Request $request, ChildOf\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted(ChildMatkaAccess::MANAGE, $childmatka);

        $command = ChildOf\Command::fromChildMatka($this->getUser()->getId(), $childmatka);

        $form = $this->createForm(ChildOf\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('work.plemmatkas.childmatkas.show', ['id' => $childmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/matkas/childmatkas/child.html.twig', [
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
        
       // $this->denyAccessUnlessGranted(ChildMatkaAccess::MANAGE, $childmatka);

        $command = new Executor\Assign\Command($this->getUser()->getId(), $childmatka->getId()->getValue());
// dd  ($command);
        $form = $this->createForm(Executor\Assign\Form::class, $command, ['plemmatka_id' => $plemmatka->getId()->getValue()]);
      
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
     * @Route("/{id}/revoke/{uchastie_id}", name=".revoke", methods={"POST"})
     * @ParamConverter("uchastie", options={"id" = "uchastie_id"})
     * @param ChildMatka $childmatka
     * @param Uchastie $uchastie
     * @param Request $request
     * @param Executor\Revoke\Handler $handler
     * @return Response
     */
    public function revoke(ChildMatka $childmatka, Uchastie $uchastie, Request $request, Executor\Revoke\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('revoke', $request->request->get('token'))) {
            return $this->redirectToRoute('paseka.matkas.childmatkas.show', ['id' => $childmatka->getId()]);
        }

       // $this->denyAccessUnlessGranted(ChildMatkaAccess::MANAGE, $childmatka);

        $command = new Executor\Revoke\Command(
            $this->getUser()->getId(),
            $childmatka->getId()->getValue(),
            $uchastie->getId()->getValue()
        );

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('paseka.matkas.childmatkas.show', ['id' => $childmatka->getId()]);
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

//        $this->denyAccessUnlessGranted(ChildMatkaAccess::MANAGE, $childmatka);

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

        //$this->denyAccessUnlessGranted(ChildMatkaAccess::MANAGE, $childmatka);

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

        //$this->denyAccessUnlessGranted(ChildMatkaAccess::MANAGE, $childmatka);

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
       // $this->denyAccessUnlessGranted(ChildMatkaAccess::MANAGE, $childmatka);

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

        return $this->render('app/work/plemmatkas/childmatkas/move.html.twig', [
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
       // $this->denyAccessUnlessGranted(ChildMatkaAccess::MANAGE, $childmatka);

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
     * @Route("/{id}/plan/remove", name=".plan.remove", methods={"POST"})
     * @param ChildMatka\ $childmatka
     * @param Request $request
     * @param Plan\Remove\Handler $handler
     * @return Response
     */
    public function removePlan(ChildMatka $childmatka, Request $request, Plan\Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('remove-plan', $request->request->get('token'))) {
            return $this->redirectToRoute('paseka.matkas.childmatkas.show', ['id' => $childmatka->getId()]);
        }

        $this->denyAccessUnlessGranted(ChildMatkaAccess::MANAGE, $childmatka);

        $command = new Plan\Remove\Command($this->getUser()->getId(), $childmatka->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('paseka.matkas.childmatkas.show', ['id' => $childmatka->getId()]);
    }

    /**
     * @Route("/{id}/delete", name=".delete", methods={"POST"})
     * @param ChildMatka $childmatka
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(ChildMatka $childmatka, Request $request, Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('paseka.matkas.childmatkas.show', ['id' => $childmatka->getId()]);
        }

        $this->denyAccessUnlessGranted(ChildMatkaAccess::DELETE, $childmatka);

        $command = new Remove\Command($childmatka->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('paseka.matkas.childmatkas');
    }

    /**
     * @Route("/{id}", name=".show", requirements={"id"="\d+"}))
     * @param ChildMatka $childmatka
     * @param Request $request
     * @param UchastieFetcher $uchasties
     * @param ChildMatkaFetcher $childmatkas
     * @param CommentFetcher $comments
     * @param ActionFetcher $actions
     * @param Status\Handler $statusHandler
     * @param Progress\Handler $progressHandler
     * @param Type\Handler $typeHandler
     * @param Priority\Handler $priorityHandler
     * @param Comment\Create\Handler
     * @return Response
     */
    public function show(
        ChildMatka $childmatka,
        Request $request,
        UchastieFetcher $uchasties,
        ChildMatkaFetcher $childmatkas,
        CommentFetcher $comments,
       ActionFetcher $actions,
        Status\Handler $statusHandler,
        Progress\Handler $progressHandler,
        Type\Handler $typeHandler,
        Priority\Handler $priorityHandler,
        Comment\Create\Handler $commentHandler
    ): Response
    {
        $this->denyAccessUnlessGranted(ChildMatkaAccess::VIEW, $childmatka);

        if (!$uchastie = $uchasties->find($this->getUser()->getId())) {
            throw $this->createAccessDeniedException();
        }

        $statusCommand = Status\Command::fromChildMatka($this->getUser()->getId(), $childmatka);
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


        $progressCommand = Progress\Command::fromChildMatka($this->getUser()->getId(), $childmatka);
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

        $typeCommand = Type\Command::fromChildMatka($this->getUser()->getId(), $childmatka);
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

        $priorityCommand = Priority\Command::fromChildMatka($this->getUser()->getId(), $childmatka);
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

        $commentCommand = new Comment\Create\Command(
            $this->getUser()->getId(),
            ChildMatka::class,
            (string)$childmatka->getId()->getValue()
        );

        $commentForm = $this->createForm(Comment\Create\Form::class, $commentCommand);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            try {
                $commentHandler->handle($commentCommand);
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
            'comments' => $comments->allForChildMatka($childmatka->getId()->getValue()),
            'actions' => $actions->allForChildMatka($childmatka->getId()->getValue()),
            'statusForm' => $statusForm->createView(),
            'progressForm' => $progressForm->createView(),
            'typeForm' => $typeForm->createView(),
            'priorityForm' => $priorityForm->createView(),
            'commentForm' => $commentForm->createView(),
        ]);
    }
}
