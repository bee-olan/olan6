<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Matkas;



use App\ReadModel\Paseka\Matkas\Actions\ActionFetcher;
use App\ReadModel\Paseka\Matkas\Actions\Filter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/paseka/matkas/actions", name="paseka.matkas.actions")
 * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
 */
class ActionsController extends AbstractController
{
    private const PER_PAGE = 50;

    private $actions;

    public function __construct(ActionFetcher $actions)
    {
        $this->actions = $actions;
    }

    /**
     * @Route("", name="")
     * @param Request $request
     * @return Response
     */
    public function index(Request $request): Response
    {
//        if ($this->isGranted('ROLE_WORK_MANAGE_PROJECTS')) {
            $filter = Filter::all();
//        } else {
//            $filter = Filter::all()->forUchastie($this->getUser()->getId());
//        }
//dd($filter);
        $pagination = $this->actions->all(
            $filter,
            $request->query->getInt('page', 1),
            self::PER_PAGE
        );

        return $this->render('app/paseka/matkas/actions.html.twig', [
            'plemmatka' => null,
            'pagination' => $pagination,
        ]);
    }
}
