<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Rasas;

use App\Annotation\Guid;
use App\Model\Paseka\Entity\Rasas\Rasa;
use App\Model\Paseka\UseCase\Rasas\Create;
use App\Model\Paseka\UseCase\Rasas\Edit;
use App\Model\Paseka\UseCase\Rasas\Remove;
use App\ReadModel\Paseka\Rasas\RasaFetcher;
use App\Controller\ErrorHandler;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/paseka/rasas", name="paseka.rasas")
 */
// @IsGranted("ROLE_Paseka_MANAGE_MATERIS")

class RasasController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    /**
     * @Route("", name="")
     * @param RasaFetcher $fetcher
     * @return Response
     */
    public function index(RasaFetcher $fetcher): Response
    {
       $rasas = $fetcher->all();
 //dd($rasas);      
  

        return $this->render('app/paseka/rasas/index.html.twig',
                                compact('rasas'));
    }

    /**
     * @Route("/create", name=".create")
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(Request $request, Create\Handler $handler): Response
    {
        $command = new Create\Command();

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('paseka.rasas');
            } catch (\DomainException $e) {
                $this->logger->warning($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/rasas/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     * @param Rasa $rasa
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Rasa $rasa, Request $request, Edit\Handler $handler): Response
    {
        $command = Edit\Command::fromRasa($rasa);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('paseka.rasas.show', ['id' => $rasa->getId()]);
            } catch (\DomainException $e) {
                $this->logger->warning($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/rasas/edit.html.twig', [
            'rasas' => $rasa,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name=".delete", methods={"POST"})
     * @param Rasa $rasa
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(Rasa $rasa, Request $request, Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('paseka.rasas.show', ['id' => $rasa->getId()]);
        }

        $command = new Remove\Command($rasa->getId()->getValue());

        try {
            $handler->handle($command);
            return $this->redirectToRoute('paseka.rasas');
        } catch (\DomainException $e) {
            $this->logger->warning($e->getMessage(), ['exception' => $e]);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('paseka.rasas.show', ['id' => $rasa->getId()]);
    }

    /**
     * @Route("/{id}", name=".show" , requirements={"id"=Guid::PATTERN})
     * @return Response
     */
    public function show(): Response
    {
        return $this->redirectToRoute('paseka.rasas');
    }
}
