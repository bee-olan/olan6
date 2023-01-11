<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\ChildMatkas;

use App\Model\Paseka\Entity\Uchasties\Uchastie\Uchastie;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\ChildOf;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Edit;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Executor;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Move;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Plan;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Priority;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Progress;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Remove;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Start;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Status;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Take;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\TakeAndStart;
use App\Model\Paseka\UseCase\Matkas\ChildMatka\Type;


use App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatka;
use App\ReadModel\Paseka\Matkas\ChildMatka\ChildMatkaFetcher;

use App\ReadModel\Paseka\Uchasties\Uchastie\UchastieFetcher;

use App\Model\Paseka\UseCase\Matkas\ChildMatka\Create;

use App\ReadModel\Proekt\Pasekas\ChildMatka\Side\Filter;
use App\ReadModel\Proekt\Pasekas\ChildMatka\Side\ChildSideFetcher;
//use App\Security\Voter\Work\Projects\ProjectAccess;
use App\Controller\ErrorHandler;
use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatka;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("proekt/pasekas/childmatkas", name="proekt.pasekas.childmatkas")
 * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
 */
class ChildTakeStartController extends AbstractController
{
    private const PER_PAGE = 50;

    private $errors;

    public function __construct( ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("/{id}/take", name=".take", methods={"POST"})
     * @param ChildMatka $childmatka
     * @param Request $request
     * @param Take\Handler $handler
     * @return Response
     */
    public function take(ChildMatka $childmatka, Request $request, Take\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('take', $request->request->get('token'))) {
            return $this->redirectToRoute('proekt.pasekas.childmatkas.show', ['id' => $childmatka->getId()]);
        }

        // $this->denyAccessUnlessGranted(ChildMatkaAccess::MANAGE, $childmatka);

        $command = new Take\Command($this->getUser()->getId(), $childmatka->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('proekt.pasekas.childmatkas.show', ['id' => $childmatka->getId()]);
    }

    /**
     * @Route("/{id}/take/start", name=".take_and_start", methods={"POST"})
     * @param ChildMatka $childmatka
     * @param Request $request
     * @param TakeAndStart\Handler $handler
     * @return Response
     */
    public function takeAndStart(ChildMatka $childmatka, Request $request, TakeAndStart\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('take-and-start', $request->request->get('token'))) {
            return $this->redirectToRoute('proekt.pasekas.childmatkas.show', ['id' => $childmatka->getId()]);
        }

        // $this->denyAccessUnlessGranted(ChildMatkaAccess::MANAGE, $childmatka);

        $command = new TakeAndStart\Command($this->getUser()->getId(), $childmatka->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('proekt.pasekas.childmatkas.show', ['id' => $childmatka->getId()]);
    }

    /**
     * @Route("/{id}/start", name=".start", methods={"POST"})
     * @param ChildMatka $childmatka
     * @param Request $request
     * @param Start\Handler $handler
     * @return Response
     */
    public function start(ChildMatka $childmatka, Request $request, Start\Handler $handler): Response
    {
        
        if (!$this->isCsrfTokenValid('start', $request->request->get('token'))) {
            return $this->redirectToRoute('proekt.pasekas.childmatkas.show', ['id' => $childmatka->getId()]);
        }

        // $this->denyAccessUnlessGranted(ChildMatkaAccess::MANAGE, $childmatka);

        $command = new Start\Command($this->getUser()->getId(), $childmatka->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('proekt.pasekas.childmatkas.show', ['id' => $childmatka->getId()]);
    }   

}

