<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Mestoo;

use App\Annotation\Guid;
use App\ReadModel\Mesto\Oblasts\CommentFetcher;
use App\ReadModel\Mesto\Oblasts\OblastFetcher;
use App\Model\Comment\UseCase\Comment;

use App\Controller\ErrorHandler;
use App\Model\Mesto\Entity\Okrugs\Okrug;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


 /**
 * @Route("/proekt/mestoo/{okrug_id}/oblasts", name="proekt.mestoo.oblasts")
 * @ParamConverter("okrug", options={"id" = "okrug_id"})
 */
class OblastsController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("", name="")
     * @param Request $request,
     * @param Okrug $okrug
     * @param OblastFetcher $oblasts
     * @param CommentFetcher $comments
     * @param Comment\Create\Handler $commentHandler
     * @return Response
     */ 
    public function oblasts(Request $request, Okrug $okrug,
                            OblastFetcher $oblasts,
                            CommentFetcher $comments,
                            Comment\Create\Handler $commentHandler
                             ): Response
    {
        //$this->denyAccessUnlessGranted(OkrugAccess::MANAGE_MEMBERS, $okrug);
        $commentCommand = new Comment\Create\Command(
            $this->getUser()->getId(),
            Okrug::class,
            (string)$okrug->getId()->getValue()
        );

        $commentForm = $this->createForm(Comment\Create\Form::class, $commentCommand);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            try {
                $commentHandler->handle($commentCommand);
                return $this->redirectToRoute('proekt.mestoo.oblasts', ['okrug_id' => $okrug->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('proekt/mestoo/oblasts.html.twig', [
            'okrug' => $okrug,
            'oblasts' => $oblasts->allOfOkrug($okrug->getId()->getValue()),
            'comments' => $comments->allForOblast($okrug->getId()->getValue()),
            'commentForm' => $commentForm->createView(),
        ]);
    }
}
