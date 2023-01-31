<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\PlemMatka\Redaktors;

use App\Annotation\Guid;

use  App\Model\Paseka\UseCase\Matkas\PlemMatka\Edit;
use App\Model\Paseka\UseCase\Matkas\PlemMatka\Archive;

use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatka;
use App\Security\Voter\Proekt\Matkas\PlemMatkaAccess;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/proekt/pasekas/matkas/plemmatkas/{plemmatka_id}/redaktorss", name="proekt.pasekas.matkas.plemmatkas.redaktorss")
 * @ParamConverter("plemmatka", options={"id" = "plemmatka_id"})
 */
class RedaktorController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("", name="", requirements={"id"=Guid::PATTERN})
     * @param PlemMatka $plemmatka
     * @return Response
     */
    public function show(PlemMatka $plemmatka): Response
    {

        $this->denyAccessUnlessGranted(PlemMatkaAccess::EDIT, $plemmatka);

        return $this->render('app/paseka/matkas/plemmatka/redaktors/show.html.twig', compact('plemmatka'));
    }

    /**
     * @Route("/edit", name=".edit")
     * @param PlemMatka $plemmatka
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(PlemMatka $plemmatka, Request $request, Edit\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted(PlemMatkaAccess::EDIT, $plemmatka);

        $command = Edit\Command::fromPlemMatka($plemmatka);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('proekt.pasekas.matkas.plemmatkas.show', ['plem_id' => $plemmatka->getId()]);
            } catch (\DomainException $e) {
                $this->logger->warning($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('proekt/pasekas/matkas/plemmatkas/redaktorss/edit.html.twig', [
            'plemmatka' => $plemmatka,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/archive", name=".archive", methods={"POST"})
     * @param PlemMatka $plemmatka
     * @param Request $request
     * @param Archive\Handler $handler
     * @return Response
     */
    public function archive(PlemMatka $plemmatka, Request $request, Archive\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('archive', $request->request->get('token'))) {
            return $this->redirectToRoute('paseka.matkas.plemmatka.show', ['id' => $plemmatka->getId()]);
        }

         $this->denyAccessUnlessGranted(PlemMatkaAccess::EDIT, plemmatka);

        $command = new Archive\Command($plemmatka->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->logger->warning($e->getMessage(), ['exception' => $e]);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('paseka.matkas.plemmatka.redaktors', ['plemmatka_id' => $plemmatka->getId()]);
    }
//
//    /**
//     * @Route("/reinstate", name=".reinstate", methods={"POST"})
//     * @param PlemMatka $plemmatka
//     * @param Request $request
//     * @param Reinstate\Handler $handler
//     * @return Response
//     */
//    public function reinstate(PlemMatka $plemmatka, Request $request, Reinstate\Handler $handler): Response
//    {
//        if (!$this->isCsrfTokenValid('reinstate', $request->request->get('token'))) {
//            return $this->redirectToRoute('work.plemmatkas.plemmatka.settings', ['plemmatka_id' => $plemmatka->getId()]);
//        }
//
//        $this->denyAccessUnlessGranted(PlemMatkaAccess::EDIT, $plemmatka);
//
//        $command = new Reinstate\Command($plemmatka->getId()->getValue());
//
//        try {
//            $handler->handle($command);
//        } catch (\DomainException $e) {
//            $this->logger->warning($e->getMessage(), ['exception' => $e]);
//            $this->addFlash('error', $e->getMessage());
//        }
//
//        return $this->redirectToRoute('work.plemmatkas.plemmatka.settings', ['plemmatka_id' => $plemmatka->getId()]);
//    }


}