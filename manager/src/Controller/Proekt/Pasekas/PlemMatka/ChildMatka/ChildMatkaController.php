<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\PlemMatka\ChildMatka;

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
 * @Route("proekt/pasekas/matkas/plemmatkas/childmatka/{plemmatka_id}/childmatka", name="proekt.pasekas.matkas.plemmatkas.childmatka")
 * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
 */
class ChildMatkaController extends AbstractController
{
    private const PER_PAGE = 50;

    private $childmatkas;
    private $errors;

    public function __construct(ChildMatkaFetcher $childmatkas, ErrorHandler $errors)
    {
        $this->childmatkas = $childmatkas;
        $this->errors = $errors;
    }

    // /**
    //  * @Route("", name="")
    //  * @param PlemMatka $plemmatka
    //  * @param Request $request
    //  * @return Response
    //  */
    // public function index(PlemMatka $plemmatka, Request $request): Response
    // {
    //    // $this->denyAccessUnlessGranted(ProjectAccess::VIEW, $project);

    //     $filter = Filter\Filter::forPlemMatka($plemmatka->getId()->getValue());

    //     $form = $this->createForm(Filter\Form::class, $filter);

    //     $form->handleRequest($request);


    //     $pagination = $this->childmatkas->allChildMat(
    //         $filter,
    //         $request->query->getInt('page', 1),
    //         self::PER_PAGE,
    //         $request->query->get('sort', 't.date'),
    //         $request->query->get('direction', 'desc')
    //     );

    //     return $this->render('proekt/pasekas/childmatkas/index.html.twig', [
    //         'plemmatka' => $plemmatka,
    //         'pagination' => $pagination,
    //         'form' => $form->createView(),
    //     ]);
    // }


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

        return $this->render('proekt/pasekas/matkas/plemmatkas/childmatka/create.html.twig', [
            'plemmatka' => $plemmatka,
            'form' => $form->createView(),
        ]);
    }
}
