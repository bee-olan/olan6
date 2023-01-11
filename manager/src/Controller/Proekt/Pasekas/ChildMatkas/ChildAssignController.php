<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\ChildMatkas;


use App\Model\Paseka\UseCase\Matkas\ChildMatka\Executor;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Plan;

use App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatka;
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
class ChildAssignController extends AbstractController
{
    private const PER_PAGE = 50;

    private $errors;

    public function __construct( ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
     * @Route("/{id}/assign", name=".assign")
     * @param ChildMatka $childmatka
     * @param Request $request
     * @param Executor\Assign\Handler $handler
     * @return Response
     */
    public function assign(ChildMatka $childmatka, Request $request, Executor\Assign\Handler $handler): Response
    {
        $plemmatka = $childmatka->getPlemMatka();
        
       // $this->denyAccessUnlessGranted(TaskAccess::MANAGE, $task);

        $command = new Executor\Assign\Command($this->getUser()->getId(), $childmatka->getId()->getValue());
// dd  ($command);
        $form = $this->createForm(Executor\Assign\Form::class, $command, ['plemmatka_id' => $plemmatka->getId()->getValue()]);
      
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('proekt.pasekas.childmatkas.show', ['id' => $childmatka->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('proekt/pasekas/childmatkas/assign.html.twig', [
            'plemmatka' => $plemmatka,
            'childmatka' => $childmatka,
            'form' => $form->createView(),
        ]);
    }
}
