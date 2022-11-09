<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Matkas\PlemMatka;

//use App\Model\Work\Entity\Projects\Project\Project;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Create;
//use App\Model\Work\UseCase\Projects\Task\Executor;
//use App\Model\Work\UseCase\Projects\Task\Plan;
use App\ReadModel\Paseka\Matkas\ChildMatka\Filter;
use App\ReadModel\Paseka\Matkas\ChildMatka\ChildMatkaFetcher;
//use App\Security\Voter\Work\Projects\ProjectAccess;
use App\Controller\ErrorHandler;
use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatka;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("paseka/matkas/{plemmatka_id}/childmatkas", name="paseka.matkas.plemmatka.childmatkas")
 * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
 */
class ChildMatkasController extends AbstractController
{
    private const PER_PAGE = 50;

    private $childmatkas;
    private $errors;

    public function __construct(ChildMatkaFetcher $childmatkas, ErrorHandler $errors)
    {
        $this->childmatkas = $childmatkas;
        $this->errors = $errors;
    }

    /**
     * @Route("", name="")
     * @param PlemMatka $plemmatka
     * @param Request $request
     * @return Response
     */
    public function index(PlemMatka $plemmatka, Request $request): Response
    {
       // $this->denyAccessUnlessGranted(ProjectAccess::VIEW, $project);

        $filter = Filter\Filter::forPlemMatka($plemmatka->getId()->getValue());

        $form = $this->createForm(Filter\Form::class, $filter);
        $form->handleRequest($request);

        $pagination = $this->childmatkas->all(
            $filter,
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort'),
            $request->query->get('direction')
        );

        return $this->render('app/paseka/matkas/childmatkas/index.html.twig', [
            'plemmatka' => $plemmatka,
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }

//    /**
//     * @Route("/me", name=".me")
//     * @param Project $project
//     * @param Request $request
//     * @return Response
//     */
//    public function me(Project $project, Request $request): Response
//    {
//        $this->denyAccessUnlessGranted(ProjectAccess::VIEW, $project);
//
//        $filter = Filter\Filter::forProject($project->getId()->getValue());
//
//        $form = $this->createForm(Filter\Form::class, $filter, [
//            'action' => $this->generateUrl('work.projects.project.tasks', ['project_id' => $project->getId()]),
//        ]);
//        $form->handleRequest($request);
//
//        $pagination = $this->tasks->all(
//            $filter->forExecutor($this->getUser()->getId()),
//            $request->query->getInt('page', 1),
//            self::PER_PAGE,
//            $request->query->get('sort'),
//            $request->query->get('direction')
//        );
//
//        return $this->render('app/work/projects/tasks/index.html.twig', [
//            'project' => $project,
//            'pagination' => $pagination,
//            'form' => $form->createView(),
//        ]);
//    }

//    /**
//     * @Route("/own", name=".own")
//     * @param Project $project
//     * @param Request $request
//     * @return Response
//     */
//    public function own(Project $project, Request $request): Response
//    {
//        $this->denyAccessUnlessGranted(ProjectAccess::VIEW, $project);
//
//        $filter = Filter\Filter::forProject($project->getId()->getValue());
//
//        $form = $this->createForm(Filter\Form::class, $filter, [
//            'action' => $this->generateUrl('work.projects.project.tasks', ['project_id' => $project->getId()]),
//        ]);
//        $form->handleRequest($request);
//
//        $pagination = $this->tasks->all(
//            $filter->forAuthor($this->getUser()->getId()),
//            $request->query->getInt('page', 1),
//            self::PER_PAGE,
//            $request->query->get('sort'),
//            $request->query->get('direction')
//        );
//
//        return $this->render('app/work/projects/tasks/index.html.twig', [
//            'project' => $project,
//            'pagination' => $pagination,
//            'form' => $form->createView(),
//        ]);
//    }

    /**
     * @Route("/create", name=".create")
     * @param PlemMatka $plemmatka
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(PlemMatka $plemmatka, Request $request, Create\Handler $handler): Response
    {
       // $this->denyAccessUnlessGranted(ProjectAccess::VIEW, $project);

        $command = new Create\Command(
            $plemmatka->getId()->getValue(),
            $this->getUser()->getId()
        );

        if ($parent = $request->query->get('parent')) {
            $command->parent = $parent;
        }

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);
//dd($plemmatka);
        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('app/paseka/matkas/plemmatka/childmatkas', ['plemmatka_id' => $plemmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/matkas/plemmatka/childmatkas/create.html.twig', [
            'plemmatka' => $plemmatka,
            'form' => $form->createView(),
        ]);
    }
}
