<?php

declare(strict_types=1);

namespace App\Controller\Sait\Uchastiess;

use App\Annotation\Guid;

// use App\ReadModel\Mesto\InfaMesto\MestoNomerFetcher;
// use App\Model\Mesto\Entity\InfaMesto\Id;
// use App\Model\Mesto\Entity\InfaMesto\MestoNomerRepository;


use App\ReadModel\Paseka\Uchasties\PersonaFetcher;
use App\ReadModel\Paseka\Uchasties\Uchastie\UchastieFetcher;
use App\ReadModel\Paseka\Uchasties\Uchastie\Filter;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Controller\ErrorHandler;


/**
 * @Route("/sait/uchastiess", name="sait.uchastiess")
 */
class InformController extends AbstractController
{
    private const PER_PAGE = 10;

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

//
//	/**
//     * @Route("/inform", name=".inform")
//     * @return Response
//     * @param PersonaFetcher $uchasties
//     */
//    public function inform(PersonaFetcher $uchasties): Response
//    {
//
//
//        $personas = $uchasties->allPers();
//
//        $personanom = $uchasties ->find($this->getUser()->getId());
//
//
//        return $this->render('sait/uchastiess/inform.html.twig',
//                                compact('personas', 'personanom'));
//    }

    /**
     * @Route("/inform", name=".inform")
     * @param Request $request
     * @param UchastieFetcher $fetcher
     * @return Response
     */
    public function inform(Request $request, UchastieFetcher $fetcher): Response
    {
        $filter = new Filter\Filter();

        $forms = $this->createForm(Filter\Form::class, $filter);
        $forms->handleRequest($request);

        $pagination = $fetcher->all(
            $filter,
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort', 'name'),
            $request->query->get('direction', 'asc')
        );
//dd($pagination);
        return $this->render('sait/uchastiess/inform.html.twig', [
            'pagination' => $pagination,
            'forms' => $forms->createView(),
        ]);
    }
}

