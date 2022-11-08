<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Matkas;

// use App\Model\Work\Entity\Members\Member\Member;
// use App\Model\Work\Entity\Projects\Task\Task;
// use App\Model\Work\UseCase\Projects\Task\ChildOf;
// use App\Model\Work\UseCase\Projects\Task\Edit;
// use App\Model\Work\UseCase\Projects\Task\Executor;
// use App\Model\Work\UseCase\Projects\Task\Move;
// use App\Model\Work\UseCase\Projects\Task\Plan;
// use App\Model\Work\UseCase\Projects\Task\Priority;
// use App\Model\Work\UseCase\Projects\Task\Progress;
// use App\Model\Paseka\UseCase\Matkas\ChildMatka\Remove;
// use App\Model\Paseka\UseCase\Matkas\ChildMatka\Start;
// use App\Model\Paseka\UseCase\Matkas\ChildMatka\Status;
// use App\Model\Paseka\UseCase\Matkas\ChildMatka\Take;
// use App\Model\Paseka\UseCase\Matkas\ChildMatka\TakeAndStart;
// use App\Model\Paseka\UseCase\Matkas\ChildMatka\Type;
// use App\ReadModel\Work\Members\Member\MemberFetcher;

use App\ReadModel\Paseka\Matkas\ChildMatka\Filter;
use App\ReadModel\Paseka\Matkas\ChildMatka\ChildMatkaFetcher;

// use App\Security\Voter\Work\Projects\TaskAccess;
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
//dd($pagination);
        return $this->render('app/paseka/matkas/childmatkas/index.html.twig', [
            'plemmatka' => null,
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }
}