<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Sezons\Tochkas\TochkaMatkas;

use App\Annotation\Guid;

use App\Controller\ErrorHandler;

use App\Model\Paseka\UseCase\Sezons\Tochkas\TochkaMatkas\Assign;
use App\Model\Paseka\Entity\Sezons\Tochkas\Tochka;
use App\ReadModel\Paseka\Matkas\ChildMatka\ChildMatkaFetcher;
use App\ReadModel\Paseka\Sezons\Tochkas\TochkaMatkas\TochkaMatkaFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sezons/tochkas/{id}/tochmatkas", name="sezons.tochkas.tochmatkas")
 */
class TochkaMatkaController extends AbstractController
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
     * @param TochkaMatkaFetcher $tochmatkas
     * @param ChildMatkaFetcher $childmatkas
     * @return Response
     */
    public function index( Request $request, Tochka $tochka,
                           TochkaMatkaFetcher $tochmatkas,
                           ChildMatkaFetcher $childmatkas): Response
    {


     $executor = $tochka->getUchasgoda()->getUchastie()->getId()->getValue();

        $childmatka = $childmatkas->listZakazForTochka($executor);

        dd($childmatka);
        // $this->denyAccessUnlessGranted(ProjectAccess::MANAGE_MEMBERS, $plemmatka);
// выводит из проекта uchastniks - учстников
        return $this->render('sezons/tochkas/tochmatkas/index.html.twig', [
            'tochka' => $tochka,
            'tochmatkas' => $tochmatkas->allOfTochka($tochka->getId()->getValue()),
        ]);
    }

    /**
     * @Route("/assign", name=".assign")
     * @param Tochka $tochka
     * @param TochkaMatkaFetcher $tochmatkas
     * @param ChildMatkaFetcher $childmatkas
     * @param Request $request
     * @param Assign\Handler $handler
     * @return Response
     */
    public function assign(Request $request, TochkaMatkaFetcher $tochmatkas,
                           Tochka $tochka,  ChildMatkaFetcher $childmatkas,
                           Assign\Handler $handler): Response
    {
//dd($tochmatkas->getUchas());
//        if ($tochmatkas->exists($this->getUser()->getId(),$tochka->getId()->getValue())) {
//            $this->addFlash('error', 'Вы уже в этом сезоне ');
//            return $this->redirectToRoute('sezons.tochkas.tochmatkas', ['id' => $tochka->getId()->getValue()]);
//        }
        $executor = $tochka->getUchasgoda()->getUchastie()->getId()->getValue();
//
//        $childmatka = $childmatkas->listZakazForTochka($executor);
//
//        dd($childmatka);


        $command = new Assign\Command($tochka->getId()->getValue());

        $form = $this->createForm(Assign\Form::class,
                                        $command,
                                ['uchastie' => $executor] );
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('sezons.tochkas.tochmatkas', ['id' => $tochka->getId()->getValue()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('sezons/tochkas/tochmatkas/assign.html.twig', [
            'tochka' => $tochka,
            'form' => $form->createView(),
        ]);
    }
//
//    /**
//     * @Route("edit", name=".edit")
//     * @param UchasTochka $tochmatka
//     * @param Request $request
//     * @param Edit\Handler $handler
//     * @return Response
//     */
//    public function edit(UchasTochka $tochmatka, Request $request, Edit\Handler $handler): Response
//    {
//        $command = Edit\Command::fromUchasTochka($tochmatka);
//
//        $form = $this->createForm(Edit\Form::class, $command);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            try {
//                $handler->handle($command);
//                return $this->redirectToRoute('sezons.tochkas.tochmatka', ['id' => $tochka->getId()->getValue()]);
//            } catch (\DomainException $e) {
//                $this->logger->warning($e->getMessage(), ['exception' => $e]);
//                $this->addFlash('error', $e->getMessage());
//            }
//        }
//
//        return $this->render('sezons/tochkas/tochmatka/edit.html.twig', [
//            'uchastie' => $uchastie,
//            'form' => $form->createView(),
//        ]);
//    }
//
//    /**
//     * @Route("/{tochmatka_id}", name=".show", requirements={"tochmatka_id"=Guid::PATTERN})
//     * @param Tochka $tochka
//     * @return Response
//     */
//    public function show(Tochka $tochka): Response
//    {
//        return $this->redirectToRoute('paseka.tochkas.tochmatka',
//            ['id' => $tochka->getId()]);
//    }
}