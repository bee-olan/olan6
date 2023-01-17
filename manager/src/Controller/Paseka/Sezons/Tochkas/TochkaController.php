<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Sezons\Tochkas;

use App\Model\Paseka\Entity\Sezons\Godas\UchasGoda;

use App\Model\Paseka\UseCase\Sezons\Tochkas\Create;

use App\Controller\ErrorHandler;
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
     * @return Response
     */
    public function index( UchasGoda $uchasgoda, Request $request): Response
    {

        //dd($uchasgoda->getGruppa());
        return $this->render('sezons/tochkas/index.html.twig', [
            'uchasgoda' => $uchasgoda,
            'tochkas' => $uchasgoda->getTochkas(),
        ]);
    }

    /**
     * @Route("/{tochok}/create", name=".create")
     * @param string $tochok
     * @param UchasGoda $uchasgoda
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(UchasGoda $uchasgoda, string $tochok, Request $request, Create\Handler $handler): Response
    {

        $gruppa =  $uchasgoda->getGruppa()." - ".$tochok;

//dd($uchasgoda->getId());
        $command = new Create\Command($uchasgoda->getId(),
                                    $gruppa);

        $form = $this->createForm(Create\Form::class, $command  );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('sezons.tochkas', ['$uchasgoda_id' => $uchasgoda->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('sezons/tochkas/create.html.twig', [
            'tochok' => $tochok,
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