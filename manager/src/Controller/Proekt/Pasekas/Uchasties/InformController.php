<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\Uchasties;

use App\Annotation\Guid;

// use App\ReadModel\Mesto\InfaMesto\MestoNomerFetcher;
// use App\Model\Mesto\Entity\InfaMesto\Id;
// use App\Model\Mesto\Entity\InfaMesto\MestoNomerRepository;
//use App\ReadModel\Proekt\Pasekas\Uchasties\Side\Filter;
//use App\ReadModel\Proekt\Pasekas\Uchasties\Side\SideFilterFetcher;

use App\ReadModel\Paseka\Uchasties\PersonaFetcher;
use App\ReadModel\Paseka\Uchasties\Uchastie\UchastieFetcher;

use App\ReadModel\Proekt\Pasekas\Uchasties\Side\SideFilterFetcher;
use App\ReadModel\Proekt\Pasekas\Uchasties\Side\Filter;

use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Controller\ErrorHandler;


/**
 * @Route("/proekt/pasekas/uchasties", name="proekt.pasekas.uchasties")
 */
class InformController extends AbstractController
{
    private const PER_PAGE = 10;

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

  /**
    * @Route("", name="")
    * @param Request $request
    * @param SideFilterFetcher $fetcher
    * @return Response
    */
    public function index(Request $request, SideFilterFetcher $fetcher): Response
    {
 
        $filter = new Filter\Filter;
 
        $form = $this->createForm(Filter\Form::class, $filter);
        $form->handleRequest($request);
 //dd($form);
        $pagination = $fetcher->all(
            $filter,
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort', 'name'),
            $request->query->get('direction', 'asc')
        );
 //dd($pagination);
        return $this->render('proekt/pasekas/uchasties/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }
 
	/**
    * @Route("/inform", name=".inform")
    * @return Response
    * @param PersonaFetcher $uchasties
    */
   public function inform(PersonaFetcher $uchasties): Response
   {


       $personas = $uchasties->allPers();

       $personanom = $uchasties ->find($this->getUser()->getId());


       return $this->render('proekt/pasekas/uchasties/inform.html.twig',
                               compact('personas', 'personanom'));
   }

//     /**
//      * @Route("/inform", name=".inform")
//      * @param Request $request
//      * @param UchastieFetcher $fetcher
//      * @return Response
//      */
//     public function inform(Request $request, UchastieFetcher $fetcher): Response
//     {
//         $filter = new Filter\Filter();

//         $forms = $this->createForm(Filter\Form::class, $filter);
//         $forms->handleRequest($request);

//         $pagination = $fetcher->all(
//             $filter,
//             $request->query->getInt('page', 1),
//             self::PER_PAGE,
//             $request->query->get('sort', 'name'),
//             $request->query->get('direction', 'asc')
//         );
// //dd($pagination);
//         return $this->render('proekt/pasekas/uchasties/inform.html.twig', [
//             'pagination' => $pagination,
//             'forms' => $forms->createView(),
//         ]);
//     }
}

