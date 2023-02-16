<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Mestoo;

use App\Annotation\Guid;

use App\Model\Comment\UseCase\Comment;

use App\Controller\ErrorHandler;
use App\Model\Mesto\Entity\Okrugs\Oblasts\Oblast;
use App\Model\Mesto\Entity\Okrugs\Id as OkrugId;
use App\Model\Mesto\Entity\Okrugs\OkrugRepository;
use App\ReadModel\Mesto\Oblasts\Raions\CommentRaiFetcher;
use App\ReadModel\Mesto\Oblasts\Raions\RaionFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/proekt/mestoo/{oblast_id}", name="proekt.mestoo")
 * @ParamConverter("oblast", options={"id" = "oblast_id"})
 */
class RaionsController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("/raions/{okrug_id}", name=".raions")
     * @param Request $request
     * @param string $okrug_id
//     * @param string $name_ok
     * @param OkrugRepository $okrugs
     * @param Oblast $oblast
     * @param RaionFetcher $raions
     * @param CommentRaiFetcher $comments
     * @param Comment\Create\Handler $commentHandler
     * @return Response
     */
    public function raions(Request $request,
                           string $okrug_id,
//                           string $name_ok,
                           OkrugRepository $okrugs,
                           Oblast $oblast,
                           CommentRaiFetcher $comments,
                           RaionFetcher $raions,
                           Comment\Create\Handler $commentHandler
                            ): Response
    {
        //$this->denyAccessUnlessGranted(OkrugAccess::MANAGE_MEMBERS, $okrug);
//        $okrug = $okrugs->get(new OkrugId($okrug_id));
       $okrug = $oblast->getOkrug();
//        dd($okrug->getName());
        $commentCommand = new Comment\Create\Command(
            $this->getUser()->getId(),
            Oblast::class,
            $oblast->getId()->getValue()
        );
        $commentForm = $this->createForm(Comment\Create\Form::class, $commentCommand);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            try {
                $commentHandler->handle($commentCommand);
                return $this->redirectToRoute('proekt.mestoo.raions',
                    ['oblast_id' => $oblast->getId(), 'okrug_id' => $okrug_id]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }
       

        return $this->render('proekt/mestoo/raions.html.twig', [
            'okrug' => $okrug,
            'oblast' => $oblast,
            'raions' => $raions->allOfOblast($oblast->getId()->getValue()),
            'comments' => $comments->allForRaion($oblast->getId()->getValue()),
            'commentForm' => $commentForm->createView(),
        ]);
    }
}
