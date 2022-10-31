<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Matkas\PlemMatka\Redaktors;

use  App\Model\Paseka\UseCase\Matkas\PlemMatka\Edit;
use App\Model\Paseka\UseCase\Matkas\PlemMatka\Archive;

use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatka;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/paseka/matkas/plemmatka/{plemmatka_id}/redaktors", name="paseka.matkas.plemmatka.redaktors")
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
     * @Route("/edit", name=".edit")
     * @param PlemMatka $plemmatka
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(PlemMatka $plemmatka, Request $request, Edit\Handler $handler): Response
    {
       // $this->denyAccessUnlessGranted(ProjectAccess::EDIT, $project);

        $command = Edit\Command::fromPlemMatka($plemmatka);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('paseka.matkas.plemmatka.show', ['id' => $plemmatka->getId()]);
            } catch (\DomainException $e) {
                $this->logger->warning($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/matkas/plemmatka/redaktors/edit.html.twig', [
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
//     * @param Project $project
//     * @param Request $request
//     * @param Reinstate\Handler $handler
//     * @return Response
//     */
//    public function reinstate(Project $project, Request $request, Reinstate\Handler $handler): Response
//    {
//        if (!$this->isCsrfTokenValid('reinstate', $request->request->get('token'))) {
//            return $this->redirectToRoute('work.projects.project.settings', ['project_id' => $project->getId()]);
//        }
//
//        $this->denyAccessUnlessGranted(ProjectAccess::EDIT, $project);
//
//        $command = new Reinstate\Command($project->getId()->getValue());
//
//        try {
//            $handler->handle($command);
//        } catch (\DomainException $e) {
//            $this->logger->warning($e->getMessage(), ['exception' => $e]);
//            $this->addFlash('error', $e->getMessage());
//        }
//
//        return $this->redirectToRoute('work.projects.project.settings', ['project_id' => $project->getId()]);
//    }


}