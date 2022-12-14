<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\PlemMatka\Redaktors;

use App\Annotation\Guid;

use App\Model\Paseka\UseCase\Matkas\PlemMatka\Uchastnik;

use App\Controller\ErrorHandler;
use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatka;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/paseka/matkas/{plemmatka_id}/redaktors/uchasties", name="paseka.matkas.plemmatka.redaktors.uchasties")
 * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
 */
class UchastiesController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("", name="")
     * @param PlemMatka $plemmatka
     * @return Response
     */
    public function index(PlemMatka $plemmatka): Response
    {
       // $this->denyAccessUnlessGranted(ProjectAccess::MANAGE_MEMBERS, $plemmatka);
// выводит из проекта uchastniks - учстников
        return $this->render('app/paseka/matkas/plemmatka/redaktors/uchasties/index.html.twig', [
            'plemmatka' => $plemmatka,
            'uchastniks' => $plemmatka->getUchastniks(),
        ]);
    }

    /**
     * @Route("/assign", name=".assign")
     * @param PlemMatka $plemmatka
     * @param Request $request
     * @param Uchastnik\Add\Handler $handler
     * @return Response
     */
    public function assign(PlemMatka $plemmatka, Request $request, Uchastnik\Add\Handler $handler): Response
    {
        // Привязывает к проекту-ПлемМатка - нового  сотрудника
       // $this->denyAccessUnlessGranted(ProjectAccess::MANAGE_MEMBERS, $plemmatka);
//Проверка на : Если попытается привязать сотрудника, но еще нет департ-сообщества, то соотв. сообщение
        if (!$plemmatka->getDepartments()) {
            $this->addFlash('error', 'Добавьте отделы перед добавлением участников.');
            return $this->redirectToRoute('paseka.matkas.plemmatka.redaktors.uchasties', ['plemmatka_id' => $plemmatka->getId()]);
        }

        $command = new Uchastnik\Add\Command($plemmatka->getId()->getValue());

        $form = $this->createForm(Uchastnik\Add\Form::class, $command, ['plemmatka' => $plemmatka->getId()->getValue()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('paseka.matkas.plemmatka.redaktors.uchasties', ['plemmatka_id' => $plemmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/matkas/plemmatka/redaktors/uchasties/assign.html.twig', [
            'plemmatka' => $plemmatka,
            'form' => $form->createView(),
        ]);
    }

//    /**
//     * @Route("/{uchastie_id}/edit", name=".edit")
//     * @param PlemMatka $plemmatka
//     * @param string $uchastie_id
//     * @param Request $request
//     * @param Uchastnik\Edit\Handler $handler
//     * @return Response
//     */
//    public function edit(PlemMatka $plemmatka, string $uchastie_id, Request $request, Uchastnik\Edit\Handler $handler): Response
//    {
//        //$this->denyAccessUnlessGranted(ProjectAccess::MANAGE_MEMBERS, $plemmatka);
//
//        $uchastnik = $plemmatka->getUchastnik(new Id($uchastie_id));
//
//        $command = Uchastnik\Edit\Command::fromUchastnik($plemmatka, $uchastnik);
//
//        $form = $this->createForm(Uchastnik\Edit\Form::class, $command, ['plemmatka' => $plemmatka->getId()->getValue()]);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            try {
//                $handler->handle($command);
//                return $this->redirectToRoute('app/paseka/matkas/plemmatka/redaktors/uchasties', ['plemmatka_id' => $plemmatka->getId()]);
//            } catch (\DomainException $e) {
//                $this->errors->handle($e);
//                $this->addFlash('error', $e->getMessage());
//            }
//        }
//
//        return $this->render('app/paseka/matkas/plemmatka/redaktors/uchasties/edit.html.twig', [
//            'plemmatka' => $plemmatka,
//            'uchastnik' => $uchastnik,
//            'form' => $form->createView(),
//        ]);
//    }
//
//    /**
//     * @Route("/{uchastie_id}/revoke", name=".revoke", methods={"POST"})
//     * @param PlemMatka $plemmatka
//     * @param string $uchastie_id
//     * @param Request $request
//     * @param Uchastnik\Remove\Handler $handler
//     * @return Response
//     */
//    public function revoke(PlemMatka $plemmatka, string $uchastie_id, Request $request, Uchastnik\Remove\Handler $handler): Response
//    {
//        //$this->denyAccessUnlessGranted(ProjectAccess::MANAGE_MEMBERS, $plemmatka);
//
//        if (!$this->isCsrfTokenValid('revoke', $request->request->get('token'))) {
//            return $this->redirectToRoute('paseka.matkas.plemmatka.redaktors.departments', ['plemmatka_id' => $plemmatka->getId()]);
//        }
//
//        $command = new Uchastnik\Remove\Command($plemmatka->getId()->getValue(), $uchastie_id);
//
//        try {
//            $handler->handle($command);
//        } catch (\DomainException $e) {
//            $this->errors->handle($e);
//            $this->addFlash('error', $e->getMessage());
//        }
//
//        return $this->redirectToRoute('paseka.matkas.plemmatka.redaktors.uchasties', ['plemmatka_id' => $plemmatka->getId()]);
//    }
//
//    /**
//     * @Route("/{uchastie_id}", name=".show", requirements={"uchastie_id"=Guid::PATTERN}))
//     * @param PlemMatka $plemmatka
//     * @return Response
//     */
//    public function show(PlemMatka $plemmatka): Response
//    {
//        return $this->redirectToRoute('paseka.matkas.plemmatka.redaktors.uchasties', ['plemmatka_id' => $plemmatka->getId()]);
//    }
}
