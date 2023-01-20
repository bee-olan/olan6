<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Sezons\Tochkas\Wzatoks;

use App\Controller\ErrorHandler;

use App\ReadModel\Paseka\Sezons\Tochkas\Wzatoks\WzatokFetcher;
use App\Model\Paseka\Entity\Sezons\Tochkas\Tochka;
use App\Model\Paseka\UseCase\Sezons\Tochkas\Create;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//     * @ParamConverter("tochka", options={"id" = "tochka_id"})
    /**
     * @Route("/sezons/tochkas/{id}/wzatoks", name="sezons.tochkas.wzatoks")
//     * @ParamConverter("tochka", options={"id" = "tochka_id"})
     */
class WzatokController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }
    /**
     * @Route("", name="")
     * @param Request $request
     * @param Tochka $tochka
     * @param WzatokFetcher $fetchers
     * @return Response
     */
    public function index(Tochka $tochka, WzatokFetcher $fetchers,  Request $request): Response
    {

        dd($tochka);
//        $wzatoks = $fetchers->allOfTochka($tochka_id);

        return $this->render('sezons/tochkas/wzatoks/index.html.twig', [
            'tochka'=> $tochka_id,
            'wzatoks' => $fetchers->allOfTochka($tochka_id),
        ]);
    }

    /**
     * @Route("/create", name=".create")
     * @param Tochka $tochka
     * @param string $tochka_id
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(string $tochka_id, Tochka $tochka, Request $request, Create\Handler $handler): Response
    {

        dd( $tochka->getId()->getValue());
        $gruppa =  $tochka->getGruppa();

dd($tochka->getId());
        $command = new Create\Command($tochka->getId(),
                                    $gruppa);

        $form = $this->createForm(Create\Form::class, $command  );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('sezons.tochkas', ['tochka_id' => $tochka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('sezons/tochkas/create.html.twig', [
            'tochok' => $tochok,
            'tochka' => $tochka,
            'form' => $form->createView(),
        ]);
    }

//    /**
//     * @Route("/edit", name=".edit")
//     * @param Tochka $tochka
//     * @param Request $request
//     * @param Edit\Handler $handler
//     * @return Response
//     */
//    public function edit(Tochka $tochka, Request $request, Edit\Handler $handler): Response
//    {
//        $command = Edit\Command::fromTochka($tochka);
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
//        return $this->render('sezons/godas/tochka/edit.html.twig', [
//            'uchastie' => $uchastie,
//            'form' => $form->createView(),
//        ]);
//    }


}