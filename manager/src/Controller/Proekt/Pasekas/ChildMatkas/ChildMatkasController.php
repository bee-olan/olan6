<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\ChildMatkas;

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

        return $this->render('proekt/pasekas/childmatkas/index.html.twig', [
            'plemmatka' => null,
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }



}
