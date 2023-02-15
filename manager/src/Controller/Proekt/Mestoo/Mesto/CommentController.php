<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Mestoo\Mesto;

use App\Controller\ErrorHandler;
use App\Model\Comment\Entity\Comment\Comment;
use App\Model\Comment\UseCase\Comment\Edit;
use App\Model\Comment\UseCase\Comment\Remove;
//use App\Model\Work\Entity\PlemMatkas\Okrug\ChildMatka;
//use App\Model\Paseka\Entity\Matkas\ChildMatka\ChildMatka;
use App\Model\Mesto\Entity\Okrugs\Okrug;
use App\Security\Voter\Comment\CommentAccess;
//use App\Security\Voter\Work\PlemMatkas\ChildMatkaAccess;
use App\Security\Voter\Proekt\Matkas\ChildMatkaAccess;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/paseka/matkas/okrugs/{okrug_id}/comments", name="paseka.matkas.okrugs.comments")
 * @ParamConverter("okrug", options={"id" = "okrug_id"})
 */
class CommentController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("/{id}/edit", name=".edit")
     * @param Okrug $okrug
     * @param Comment $comment
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Okrug $okrug, Comment $comment, Request $request, Edit\Handler $handler): Response
    {
        $this->denyAccessUnlessGranted(OkrugAccess::VIEW, $okrug);
        $this->checkCommentIsForOkrug($okrug, $comment);
        $this->denyAccessUnlessGranted(CommentAccess::MANAGE, $comment);

        $command = Edit\Command::fromComment($comment);

        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('paseka.matkas.okrugs.show', ['id' => $okrug->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/matkas/okrugs/comment/edit.html.twig', [
            'okrug' => $oblast->getOkrug(),
            'okrug' => $okrug,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/delete", name=".delete", methods={"POST"})
     * @param Okrug $okrug
     * @param Comment $comment
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(Okrug $okrug, Comment $comment, Request $request, Remove\Handler $handler): Response
    {
        if (!$this->isCsrfTokenValid('delete-comment', $request->request->get('token'))) {
            return $this->redirectToRoute('work.projects.okrugs.show', ['id' => $okrug->getId()]);
        }

        $this->denyAccessUnlessGranted(OkrugAccess::VIEW, $okrug);
        $this->checkCommentIsForOkrug($okrug, $comment);
        $this->denyAccessUnlessGranted(CommentAccess::MANAGE, $comment);

        $command = new Remove\Command($comment->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('work.projects.okrugs.show', ['id' => $okrug->getId()]);
    }

    private function checkCommentIsForOkrug(Okrug $okrug, Comment $comment): void
    {
        if (!(
            $comment->getEntity()->getType() === Okrug::class &&
            (int)$comment->getEntity()->getId() === $okrug->getId()->getValue()
        )) {
            throw $this->createNotFoundException();
        }
    }
}
