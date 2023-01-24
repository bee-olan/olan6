<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Sezons\Tochkas;

use App\Model\Paseka\Entity\Sezons\Godas\UchasGoda;

use App\Model\Paseka\UseCase\Sezons\Tochkas\Create;

use App\Controller\ErrorHandler;
use App\ReadModel\Paseka\Sezons\Godas\UchasGodaFetcher;
use App\ReadModel\Paseka\Sezons\Tochkas\TochkaFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sezons/{uchasgoda_id}/tochkas", name="sezons.tochkas")
 * @ParamConverter("uchasgoda", options={"id" = "uchasgoda_id"})
 */
class TochkaController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }
    /**
     * @Route("", name="")
     * @param Request $request
     * @param UchasGoda $uchasgoda
     * @param TochkaFetcher $fetchers
     * @return Response
     */
    public function index(Request $request, TochkaFetcher $fetchers, UchasGoda $uchasgoda): Response
    {
//dd($uchasgoda->getKoltochek());

$tochoks = $fetchers->allOfUchasGoda($uchasgoda->getId());

//if( !($tochoks[$uchasgoda->getKoltochek()-1]['tochka'])){ $fignja=0; }
//else
//    { $fignja=$tochoks[$uchasgoda->getKoltochek()-1]['tochka'];}

//dd( $tochoks[$uchasgoda->getKoltochek()-1]['tochka']);
        $counts = count($tochoks);
        return $this->render('sezons/tochkas/index.html.twig', [
            'counts' => $counts,
            'uchasgoda' => $uchasgoda,
            'tochkas' => $tochoks,
        ]);
    }


    /**
     * @Route("/create", name=".create")
     * @param TochkaFetcher $fetchers
     * @param UchasGoda $uchasgoda
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(UchasGoda $uchasgoda, TochkaFetcher $fetchers, Request $request, Create\Handler $handler): Response
    {
        
    //   $koless= $fetchers->allOfUchasGoda($uchasgoda->getId());
        
        $tochka = (int)$fetchers->getMaxTochka($uchasgoda->getId())+1;
        $gruppa =  $uchasgoda->getGruppa()." - ". $tochka;

//dd($uchasgoda->getId());
        $command = new Create\Command($uchasgoda->getId(),
                                    $gruppa, $tochka);

        $form = $this->createForm(Create\Form::class, $command  );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('sezons.tochkas', ['uchasgoda_id' => $uchasgoda->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('sezons/tochkas/create.html.twig', [
           
            'nomtochka' => $tochka,
            'uchasgoda' => $uchasgoda,
            'form' => $form->createView(),
        ]);
    }

//    /**
//     * @Route("/edit", name=".edit")
//     * @param UchasGoda $uchasgoda
//     * @param Request $request
//     * @param Edit\Handler $handler
//     * @return Response
//     */
//    public function edit(UchasGoda $uchasgoda, Request $request, Edit\Handler $handler): Response
//    {
//        $command = Edit\Command::fromUchasGoda($uchasgoda);
//
//        $form = $this->createForm(Edit\Form::class, $command);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            try {
//                $handler->handle($command);
//                return $this->redirectToRoute('paseka.uchasties.show', ['id' => $uchastie->getId()]);
//            } catch (\DomainException $e) {
//                $this->logger->warning($e->getMessage(), ['exception' => $e]);
//                $this->addFlash('error', $e->getMessage());
//            }
//        }
//
//        return $this->render('sezons/godas/uchasgoda/edit.html.twig', [
//            'uchastie' => $uchastie,
//            'form' => $form->createView(),
//        ]);
//    }


}