<?php

declare(strict_types=1);

namespace App\Controller\Sait\SideFilter;

use App\Annotation\Guid;

use App\ReadModel\Sait\SideFilter\Filter;
use App\ReadModel\Sait\SideFilter\SideFilterFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/sait/uchastiess", name="sait.uchastiess")
*/
class SideFilterController extends AbstractController
{
   private const PER_PAGE = 10;

   private $logger;

   public function __construct(LoggerInterface $logger)
   {
       $this->logger = $logger;
   }

   /**
    * @Route("/", name="")
    * @param Request $request
    * @param SideFilterFetcher $fetcher
    * @return Response
    */
   public function index(Request $request, SideFilterFetcher $fetcher): Response
   {

       $filter = new Filter\Filter;

       $form = $this->createForm(Filter\Form::class, $filter);
       $form->handleRequest($request);

       $pagination = $fetcher->all(
           $filter,
           $request->query->getInt('page', 1),
           self::PER_PAGE,
           $request->query->get('sort', 'name'),
           $request->query->get('direction', 'asc')
       );
//dd($pagination);
       return $this->render('sait/uchastiess/index.html.twig', [
           'pagination' => $pagination,
           'form' => $form->createView(),
       ]);
   }

}
