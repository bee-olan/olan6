<?php

declare(strict_types=1);

namespace App\Controller\Mesto;

//use App\Model\Paseka\Entity\U4astniki\Mesto\Okrug;

use App\Model\Mesto\UseCase\Okrugs\Create;
use App\Model\Mesto\UseCase\Okrugs\Edit;
use App\Model\Mesto\UseCase\Okrugs\Remove;

use App\ReadModel\Mesto\OkrugFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mesto", name="mesto")
 */
class OkrugsController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("", name="")
     * @param OkrugFetcher $fetcher
     * @return Response
     */
    public function index(OkrugFetcher $fetcher): Response
    {
        $okrugs = $fetcher->all();
        return $this->render('app/mesto/index.html.twig', compact('okrugs'));
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
                return $this->redirectToRoute('mesto');
            } catch (\DomainException $e) {
                $this->logger->error($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/mesto/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

//    /**
//     * @Route("/{id}/edit", name=".edit")
//     * @param Okrug $okrug
//     * @param Request $request
//     * @param Edit\Handler $handler
//     * @return Response
//     */
//    public function edit(Okrug $okrug, Request $request, Edit\Handler $handler): Response
//    {
//        $command = Edit\Command::fromOkrug($okrug);
//
//        $form = $this->createForm(Edit\Form::class, $command);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            try {
//                $handler->handle($command);
//                return $this->redirectToRoute('mesto.show', ['id' => $okrug->getId()]);
//            } catch (\DomainException $e) {
//                $this->logger->error($e->getMessage(), ['exception' => $e]);
//                $this->addFlash('error', $e->getMessage());
//            }
//        }
//
//        return $this->render('app/mesto/edit.html.twig', [
//            'okrug' => $okrug,
//            'form' => $form->createView(),
//        ]);
//    }

//    /**
//     * @Route("/{id}/delete", name=".delete", methods={"POST"})
//     * @param Okrug $okrug
//     * @param Request $request
//     * @param Remove\Handler $handler
//     * @return Response
//     */
//    public function delete(Okrug $okrug, Request $request, Remove\Handler $handler): Response
//    {
//        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
//            return $this->redirectToRoute('mesto.show', ['id' => $okrug->getId()]);
//        }
//
//        $command = new Remove\Command($okrug->getId()->getValue());
//
//        try {
//            $handler->handle($command);
//            return $this->redirectToRoute('mesto');
//        } catch (\DomainException $e) {
//            $this->logger->error($e->getMessage(), ['exception' => $e]);
//            $this->addFlash('error', $e->getMessage());
//        }
//
//        return $this->redirectToRoute('mesto.show', ['id' => $okrug->getId()]);
//    }

    /**
     * @Route("/{id}", name=".show")
     * @return Response
     */
    public function show(): Response
    {
        return $this->redirectToRoute('mesto');
    }
}
