<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\ChildMatkas;


use App\Model\Paseka\UseCase\Matkas\ChildMatka\Executor;

use App\Model\Paseka\UseCase\Matkas\ChildMatka\Plan;

use App\ReadModel\Proekt\Pasekas\ChildMatka\Side\Filter;
use App\ReadModel\Proekt\Pasekas\ChildMatka\Side\ChildSideFetcher;

use App\Controller\ErrorHandler;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("proekt/pasekas/childmatkas", name="proekt.pasekas.childmatkas")
 * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
 */
class ChildMeeOwnController extends AbstractController
{
    private const PER_PAGE = 50;

    private $errors;

    public function __construct( ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
     * @Route("/me", name=".me")
     * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
     * @param Request $request
     * @param ChildSideFetcher $childmatkas
     * @return Response
     */
    public function me(Request $request, ChildSideFetcher $childmatkas): Response
    {
        $filter = Filter\Filter::alll();

        $form = $this->createForm(Filter\Form::class, $filter, [
            'action' => $this->generateUrl('proekt.pasekas.childmatkas'),
        ]);

        $form->handleRequest($request);

        $pagination = $childmatkas->alll(
            $filter->forExecutor($this->getUser()->getId()),
            $request->query->getInt('page', 1),
            self::PER_PAGE,
//            $request->query->get('sort'),
//            $request->query->get('direction')
            $request->query->get('sort'),
            $request->query->get('direction')
        );

        return $this->render('proekt/pasekas/childmatkas/index.html.twig', [
            'plemmatka' => null,
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/own", name=".own")
     * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
     * @param Request $request
     * @param ChildSideFetcher $childmatkas
     * @return Response
     */
    public function own(Request $request, ChildSideFetcher $childmatkas): Response
    {
        $filter = Filter\Filter::alll();

        $form = $this->createForm(Filter\Form::class, $filter, [
            'action' => $this->generateUrl('proekt.pasekas.childmatkas'),
        ]);

        $form->handleRequest($request);

        $pagination = $childmatkas->alll(
            $filter->forAuthor($this->getUser()->getId()),
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort'),
            $request->query->get('direction')
        );

        return $this->render('proekt/pasekas/childmatkas/index.html.twig', [
            'plemmatka' => null,
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }

}


