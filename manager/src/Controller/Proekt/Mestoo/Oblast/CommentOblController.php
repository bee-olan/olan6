<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Mestoo\Oblast;

use App\Controller\ErrorHandler;
use App\Model\Comment\Entity\Comment\Comment;
use App\Model\Comment\UseCase\Comment\Edit;
use App\Model\Comment\UseCase\Comment\Remove;

use App\Model\Mesto\Entity\Okrugs\Oblasts\Oblast;
use App\Security\Voter\Comment\CommentAccess;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/proekt/mestoo/{oblast_id}/comment", name="proekt.mestoo.comment")
 * @ParamConverter("oblast", options={"id" = "oblast_id"})
 */
class CommentOblController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     * @param Oblast $oblast
     * @param Comment $comment
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Oblast $oblast, Comment $comment, Request $request, Edit\Handler $handler): Response
    {
//        dd($oblast->getOkrug()->getName());
//        $this->denyAccessUnlessGranted(OblastAccess::VIEW, $oblast);
        $this->checkCommentIsForOblast($oblast, $comment);
        $this->denyAccessUnlessGranted(CommentAccess::MANAGE, $comment);

        $command = Edit\Command::fromComment($comment);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('proekt.mestoo.raions', ['id' => $oblast->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/work/projects/oblasts/comment/edit.html.twig', [
            'okrug' => $oblast->getOrkug(),
            'oblast' => $oblast,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name=".delete", methods={"POST"})
     * @param Oblast $oblast
     * @param Comment $comment
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(Oblast $oblast, Comment $comment, Request $request, Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('delete-comment', $request->request->get('token'))) {
            return $this->redirectToRoute('work.projects.oblasts.show', ['id' => $oblast->getId()]);
        }

//        $this->denyAccessUnlessGranted(OblastAccess::VIEW, $oblast);
        $this->checkCommentIsForOblast($oblast, $comment);
        $this->denyAccessUnlessGranted(CommentAccess::MANAGE, $comment);

        $command = new Remove\Command($comment->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('work.projects.oblasts.show', ['id' => $oblast->getId()]);
    }

    private function checkCommentIsForOblast(Oblast $oblast, Comment $comment): void
    {
        if (!(
            $comment->getEntity()->getType() === Oblast::class &&
            $comment->getEntity()->getId() === $oblast->getId()->getValue()
        )) {
            throw $this->createNotFoundException();
        }
    }
}
