<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Sezons\Godas;

use App\Annotation\Guid;

use App\Model\Paseka\UseCase\Sezons\Godas\Create;
use App\Model\Paseka\UseCase\Sezons\Godas\Edit;
use App\Model\Paseka\UseCase\Sezons\Godas\Remove;

use App\Model\Paseka\Entity\Sezons\Godas\Goda;
use App\ReadModel\Paseka\Sezons\Godas\GodaFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/sezons/godas", name="sezons.godas")
 */
class GodaController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("", name="")
     * @param GodaFetcher $godas
     * @return Response
     */
    public function index(GodaFetcher $godas): Response
    {

        $godas = $godas->all();

        return $this->render('sezons/godas/index.html.twig', compact('godas'));
    }

    /**
     * @Route("/create", name=".create")
     * @param GodaFetcher $godas
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(Request $request,  GodaFetcher $godas, Create\Handler $handler): Response
    {
        $godMax = $godas->getMaxGod() + 1;

        if ($godMax < 2014) { $godMax = 2015;}

        $command = new Create\Command($godMax);

            try {
                $handler->handle($command);
                return $this->redirectToRoute('sezons.godas');
            } catch (\DomainException $e) {
                $this->logger->warning($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        return $this->render('sezons/godas/create.html.twig');
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     * @param Goda $goda
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Goda $goda, Request $request, Edit\Handler $handler): Response
    {
        $command = Edit\Command::fromGoda($goda);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('sezons.godas.show', ['id' => $goda->getId()]);
            } catch (\DomainException $e) {
                $this->logger->warning($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('sezons/godas/edit.html.twig', [
            'godas' => $goda,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name=".delete", methods={"POST"})
     * @param Goda $goda
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(Goda $goda, Request $request, Remove\Handler $handler): Response
    {

        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('sezons.godas');
        }

        $command = new Remove\Command($goda->getId()->getValue());

        try {
            $handler->handle($command);
            return $this->redirectToRoute('sezons.godas.');
        } catch (\DomainException $e) {
            $this->logger->warning($e->getMessage(), ['exception' => $e]);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('sezons.godas.show', ['id' => $goda->getId()]);
    }

    /**
     * @Route("/{id}", name=".show", requirements={"id"=Guid::PATTERN})
     * @return Response
     */
    public function show(): Response
    {
        return $this->redirectToRoute('sezons.godas');
    }


}
