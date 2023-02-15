<?php

declare(strict_types=1);

namespace App\Controller\Mesto\Okrugs\Oblasts;

use App\Model\Comment\UseCase\Comment;
use App\Controller\ErrorHandler;
use App\Model\Mesto\Entity\Okrugs\Oblasts\Oblast;
use App\Model\Mesto\UseCase\Okrugs\Oblasts\Create;
use App\Model\Mesto\UseCase\Okrugs\Oblasts\Edit;
use App\Model\Mesto\UseCase\Okrugs\Oblasts\Remove;

use App\Model\Mesto\Entity\Okrugs\Oblasts\Id;

use App\Annotation\Guid;
use App\Model\Mesto\Entity\Okrugs\Okrug;
use App\ReadModel\Mesto\Oblasts\CommentFetcher;
use App\ReadModel\Mesto\Oblasts\OblastFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;;

/**
 * @Route("/mesto/okrug/{id}/oblast", name="mesto.okrug.oblast")
 */
class OblastController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("/", name="")
     * @param Request $request,
     * @param Okrug $okrug
//     * @param Oblast $oblast
     * @param OblastFetcher $oblasts
     * @param CommentFetcher $comments
     * @param Comment\Create\Handler $commentHandler
     * @return Response
     */
    public function index(Request $request, Okrug $okrug,
                          OblastFetcher $oblasts,
                          CommentFetcher $comments,
                          Comment\Create\Handler $commentHandler
                            ): Response
    {
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
                return $this->redirectToRoute('mesto.okrug.oblast', ['id' => $okrug->getId()]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/mesto/okrug/oblast/index.html.twig', [
            'okrug' => $okrug,
            'oblasts' => $oblasts->allOfOkrug($okrug->getId()->getValue()),
            'comments' => $comments->allForOblast($okrug->getId()->getValue()),
            'commentForm' => $commentForm->createView(),
        ]);
    }

    /**
     * @Route("/create", name=".create")
     * @param Okrug $okrug
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(Okrug $okrug, Request $request, Create\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(OkrugAccess::MANAGE_MEMBERS, $okrug);
        $command = new Create\Command($okrug->getId()->getValue());
        $command->mesto = $okrug->getNomer();
//dd($command->mesto);
        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {

                $handler->handle($command);

                return $this->redirectToRoute('mesto.okrug.oblast', ['id' => $okrug->getId()]);

                } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/mesto/okrug/oblast/create.html.twig', [
            'okrug' => $okrug,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{oblast_id}/edit", name=".edit")
     * @param Okrug $okrug
     * @param string $oblast_id
     * @param Request $request
     * @param Edit\Handler $handler
     * @return Response
     */
    public function edit(Okrug $okrug, string $oblast_id, Request $request, Edit\Handler $handler): Response
    {
        // $this->denyAccessUnlessGranted(OkrugAccess::MANAGE_MEMBERS, $okrug);

        $oblast = $okrug->getOblast(new Id($oblast_id));

        $command = Edit\Command::fromOblast($okrug, $oblast);
        // dd($command);
        $form = $this->createForm(Edit\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                 $command->mesto = $okrug->getNomer()."-".$command->nomer;

                $handler->handle($command);
                return $this->redirectToRoute('mesto.okrug.oblast.show', ['id' => $okrug->getId(), 'oblast_id' => $oblast_id]);
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/mesto/okrug/oblast/edit.html.twig', [
            'okrug' => $okrug,
            'oblast' => $oblast,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{oblast_id}/delete", name=".delete", methods={"POST"})
     * @param Okrug $okrug
     * @param string $oblast_id
     * @param Request $request
     * @param Remove\Handler $handler
     * @return Response
     */
    public function delete(Okrug $okrug, string $oblast_id, Request $request, Remove\Handler $handler): Response
    {
        //$this->denyAccessUnlessGranted(OkrugAccess::MANAGE_MEMBERS, $okrug);

        if (!$this->isCsrfTokenValid('delete', $request->request->get('token'))) {
            return $this->redirectToRoute('mesto.okrug.oblast', ['id' => $okrug->getId()]);
        }

        $oblast = $okrug->getOblast(new Id($oblast_id));

        $command = new Remove\Command($okrug->getId()->getValue(), $oblast->getId()->getValue());

        try {
            $handler->handle($command);
        } catch (\DomainException $e) {
            $this->errors->handle($e);
            $this->addFlash('error', $e->getMessage());
        }

        return $this->redirectToRoute('mesto.okrug.oblast', ['id' => $okrug->getId()]);
    }

    /**
     * @Route("/{oblast_id}", name=".show", requirements={"id"=Guid::PATTERN}))
     * @param Okrug $okrug
     * @return Response
     */
    public function show(Okrug $okrug): Response
    {
        return $this->redirectToRoute('mesto.okrug.oblast', ['id' => $okrug->getId()]);
    }

}