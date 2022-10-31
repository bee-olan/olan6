<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Uchasties;

use App\Annotation\Guid;
use App\Model\Paseka\Entity\Uchasties\Personas\Persona;
use App\Model\User\Entity\User\User;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Uchastie;

use App\Model\Paseka\UseCase\Uchasties\Uchastie\Archive;
use App\Model\Paseka\UseCase\Uchasties\Uchastie\Edit;
use App\Model\Paseka\UseCase\Uchasties\Uchastie\Reinstate;
use App\Model\Paseka\UseCase\Uchasties\Uchastie\Create;
use App\Model\Paseka\UseCase\Uchasties\Uchastie\Move;
use App\ReadModel\Paseka\Uchasties\Uchastie\Filter;
use App\ReadModel\Paseka\Uchasties\Uchastie\UchastieFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/paseka/uchasties", name="paseka.uchasties")
 */
class UchastiesController extends AbstractController
{
    private const PER_PAGE = 10;

    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("", name="")
     * @param Request $request
     * @param UchastieFetcher $fetcher
     * @return Response
     */
    public function index(Request $request, UchastieFetcher $fetcher): Response
    {
        $filter = new Filter\Filter();

        $form = $this->createForm(Filter\Form::class, $filter);
        $form->handleRequest($request);

        $pagination = $fetcher->all(
            $filter,
            $request->query->getInt('page', 1),
            self::PER_PAGE,
            $request->query->get('sort', 'name'),
            $request->query->get('direction', 'asc')
        );
//dd($pagination);
        return $this->render('app/paseka/uchasties/index.html.twig', [
            'pagination' => $pagination,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/create/{id}", name=".create")
     * @param User $user
     * @param Request $request
     * @param UchastieFetcher $uchasties
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(User $user, Request $request, UchastieFetcher $uchasties, Create\Handler $handler): Response
    {
        if ($uchasties->exists($user->getId()->getValue())) {
            $this->addFlash('error', 'Uchastie уже существует..');
            return $this->redirectToRoute('users.show', ['id' => $user->getId()]);
        }
// следующие присваения перенести в Handler не можим т.к. инфа  из $user
        $command = new Create\Command($user->getId()->getValue());
        $command->firstName = $user->getName()->getFirst();
        $command->lastName = $user->getName()->getLast();
        //$command->email = $user->getEmail() ? $user->getEmail()->getValue() : null;

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('paseka.uchasties.show', ['id' => $user->getId()]);
            } catch (\DomainException $e) {
                $this->logger->warning($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/uchasties/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

//    /**
//     * @Route("/{id}/edit", name=".edit")
//     * @param Uchastie $uchastie
//     * @param Request $request
//     * @param Edit\Handler $handler
//     * @return Response
//     */
//    public function edit(Uchastie $uchastie, Request $request, Edit\Handler $handler): Response
//    {
//        $command = Edit\Command::fromUchastie($uchastie);
//
//        $form = $this->createForm(Edit\Form::class, $command);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            try {
//                $handler->handle($command);
//                return $this->redirectToRoute('paseka.uchasties.show', ['id' => $uchastie->getId()]);
//            } catch (\DomainException $e) {
//                $this->logger->warning($e->getMessage(), ['exception' => $e]);
//                $this->addFlash('error', $e->getMessage());
//            }
//        }
//
//        return $this->render('app/paseka/uchasties/edit.html.twig', [
//            'uchastie' => $uchastie,
//            'form' => $form->createView(),
//        ]);
//    }
//
//    /**
//     * @Route("/{id}/move", name=".move")
//     * @param Uchastie $uchastie
//     * @param Request $request
//     * @param Move\Handler $handler
//     * @return Response
//     */
//    public function move(Uchastie $uchastie, Request $request, Move\Handler $handler): Response
//    {
//        $command = Move\Command::fromUchastie($uchastie);
//
//        $form = $this->createForm(Move\Form::class, $command);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            try {
//                $handler->handle($command);
//                return $this->redirectToRoute('paseka.uchasties.show', ['id' => $uchastie->getId()]);
//            } catch (\DomainException $e) {
//                $this->logger->warning($e->getMessage(), ['exception' => $e]);
//                $this->addFlash('error', $e->getMessage());
//            }
//        }
//
//        return $this->render('app/paseka/uchasties/move.html.twig', [
//            'uchastie' => $uchastie,
//            'form' => $form->createView(),
//        ]);
//    }
//
//    /**
//     * @Route("/{id}/archive", name=".archive", methods={"POST"})
//     * @param Uchastie $uchastie
//     * @param Request $request
//     * @param Archive\Handler $handler
//     * @return Response
//     */
//    public function archive(Uchastie $uchastie, Request $request, Archive\Handler $handler): Response
//    {
//        if (!$this->isCsrfTokenValid('archive', $request->request->get('token'))) {
//            return $this->redirectToRoute('paseka.uchasties.show', ['id' => $uchastie->getId()]);
//        }
//
//        $command = new Archive\Command($uchastie->getId()->getValue());
//
//        try {
//            $handler->handle($command);
//        } catch (\DomainException $e) {
//            $this->logger->warning($e->getMessage(), ['exception' => $e]);
//            $this->addFlash('error', $e->getMessage());
//        }
//
//        return $this->redirectToRoute('paseka.uchasties.show', ['id' => $uchastie->getId()]);
//    }
//
//    /**
//     * @Route("/{id}/reinstate", name=".reinstate", methods={"POST"})
//     * @param Uchastie $uchastie
//     * @param Request $request
//     * @param Reinstate\Handler $handler
//     * @return Response
//     */
//    public function reinstate(Uchastie $uchastie, Request $request, Reinstate\Handler $handler): Response
//    {
//        if (!$this->isCsrfTokenValid('reinstate', $request->request->get('token'))) {
//            return $this->redirectToRoute('paseka.uchasties.show', ['id' => $uchastie->getId()]);
//        }
//
//        if ($uchastie->getId()->getValue() === $this->getUser()->getId()) {
//            $this->addFlash('error', 'Unable to reinstate yourself.');
//            return $this->redirectToRoute('paseka.uchasties.show', ['id' => $uchastie->getId()]);
//        }
//
//        $command = new Reinstate\Command($uchastie->getId()->getValue());
//
//        try {
//            $handler->handle($command);
//        } catch (\DomainException $e) {
//            $this->logger->warning($e->getMessage(), ['exception' => $e]);
//            $this->addFlash('error', $e->getMessage());
//        }
//
//        return $this->redirectToRoute('paseka.uchasties.show', ['id' => $uchastie->getId()]);
//    }
//
    /**
     * @Route("/{id}", name=".show", requirements={"id"=Guid::PATTERN})
     * @param Uchastie $uchastie
     * @param Persona $persona
     * @return Response
     */
    public function show(Uchastie $uchastie, Persona $persona): Response
    {
        return $this->render('app/paseka/uchasties/show.html.twig', compact('uchastie', 'persona'));
    }
}
