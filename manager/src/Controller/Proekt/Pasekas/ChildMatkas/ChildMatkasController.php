<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\ChildMatkas;

//use App\Model\Work\Entity\Projects\Project\Project;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Create;
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

use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatka;
use App\ReadModel\Proekt\Pasekas\ChildMatka\Side\Filter;
use App\ReadModel\Proekt\Pasekas\ChildMatka\Side\ChildSideFetcher;
//use App\Security\Voter\Work\Projects\ProjectAccess;
use App\Controller\ErrorHandler;
use App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatka;
use App\ReadModel\Proekt\Pasekas\PlemMatka\Side\PlemSideFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("proekt/pasekas/childmatkas", name="proekt.pasekas.childmatkas")
 * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
 */
class ChildMatkasController extends AbstractController
{
    private const PER_PAGE = 50;

    private $errors;

    public function __construct( ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("", name="")
     * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
     * @param Request $request
     * @param ChildSideFetcher $childmatkas
     * @return Response
     */
    public function index(Request $request, ChildSideFetcher $childmatkas): Response
    {
        // if ($this->isGranted('ROLE_WORK_MANAGE_PROJECTS')) {
             $filter = Filter\Filter::all();
        // } else {
         //   $filter = Filter\Filter::all()->forUchastie($this->getUser()->getId());
       // }

        $form = $this->createForm(Filter\Form::class, $filter);
        $form->handleRequest($request);

        $pagination = $childmatkas->all(
            $filter,
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort', 't.id'),
            $request->query->get('direction', 'desc')
        );

        return $this->render('proekt/pasekas/childmatkas/index.html.twig', [
            'plemmatka' => null,
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/create", name=".create")
     * @param PlemMatka $plemmatka
     * @param PlemSideFetcher $plemSideFetcher
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create( PlemMatka $plemmatka, Request $request, Create\Handler $handler): Response
    {
       // $this->denyAccessUnlessGranted(ProjectAccess::VIEW, $project);


        $command = new Create\Command(
            $plemmatka->getId()->getValue(),
            $this->getUser()->getId()
        );

        if ($parent = $request->query->get('parent')) {
            $command->parent = $parent;
        }
        $command->name = "hhh";
        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);
//dd($plemmatka);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('proekt.pasekas.childmatkas');
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('proekt/pasekas/childmatkas/create.html.twig', [
            'plemmatka' => $plemmatka,
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
                return $this->redirectToRoute('proekt.pasekas.childmatkas.show', ['id' => $childmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('proekt/pasekas/childmatkas/edit.html.twig', [
            'plemmatka' => $childmatka->getPlemMatka(),
            'childmatka' => $childmatka,
            'form' => $form->createView(),
        ]);
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
                return $this->redirectToRoute('proekt.pasekas.childmatkas.show', ['id' => $childmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('proekt/pasekas/childmatkas/move.html.twig', [
            'plemmatka' => $childmatka->getPlemMatka(),
            'childmatka' => $childmatka,
            'form' => $form->createView(),
        ]);
    }


}


