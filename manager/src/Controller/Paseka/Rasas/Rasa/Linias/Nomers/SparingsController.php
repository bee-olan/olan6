<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Rasas\Rasa\Linias\Nomers;

use App\Model\Paseka\Entity\Rasas\Linias\Nomers\Sparings\Sparing;
use App\Model\Paseka\UseCase\Rasas\Linias\Nomers\Sparings\Create;
use App\Model\Paseka\UseCase\Rasas\Linias\Nomers\Sparings\Edit;
use App\Model\Paseka\UseCase\Rasas\Linias\Nomers\Sparings\Remove;
use App\ReadModel\Paseka\Rasas\Linias\Nomers\SparingFetcher;
use App\Controller\ErrorHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// * @IsGranted("ROLE_Paseka_MANAGE_MATERIS")
/**
 * @Route("/paseka/rasas/linias/nomers/sparings", name="paseka.rasas.linias.nomers.sparings")
 */
class SparingsController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("", name="")
     * @param SparingFetcher $fetcher
     * @return Response
     */
    public function index(SparingFetcher $fetcher): Response
    {
        $sparings = $fetcher->all();

        return $this->render('app/paseka/rasas/linias/nomers/sparings/index.html.twig', compact('sparings'));
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
                return $this->redirectToRoute('paseka.rasas.linias.nomers.sparings');
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/rasas/linias/nomers/sparings/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     * @param Sparing $sparing
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Sparing $sparing, Request $request, Edit\Handler $handler): Response
    {
        $command = Edit\Command::fromSparing($sparing);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('paseka.rasas.linias.nomers.sparings.show', ['id' => $sparing->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/rasas/linias/nomers/sparings/edit.html.twig', [
            'sparing' => $sparing,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name=".delete", methods={"POST"})
     * @param Sparing $sparing
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(Sparing $sparing, Request $request, Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('paseka.rasas.linias.nomers.sparings.show', ['id' => $sparing->getId()]);
        }

        $command = new Remove\Command($sparing->getId()->getValue());

        try {
            $handler->handle($command);
            return $this->redirectToRoute('paseka.rasas.linias.nomers.sparings');
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('paseka.rasas.linias.nomers.sparings.show', ['id' => $sparing->getId()]);
    }

    /**
     * @Route("/{id}", name=".show")
     * @return Response
     */
    public function show(): Response
    {
        return $this->redirectToRoute('paseka.rasas.linias.nomers.sparings');
    }
}