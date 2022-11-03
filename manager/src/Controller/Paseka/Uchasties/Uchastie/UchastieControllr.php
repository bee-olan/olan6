<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Uchasties\Uchastie;

use App\Annotation\Guid;

use App\Model\Paseka\Entity\Uchasties\Uchastie\Id;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Uchastie;
use App\Model\Paseka\UseCase\Uchasties\Uchastie\Create;
use App\Model\Paseka\Entity\Uchasties\Uchastie\UchastieRepository;

use App\Model\User\Entity\User\UserRepository;
use App\ReadModel\Mesto\InfaMesto\MestoNomerFetcher;
use App\ReadModel\Paseka\Uchasties\PersonaFetcher;
use App\ReadModel\Paseka\Uchasties\Uchastie\UchastieFetcher;
use App\ReadModel\User\UserFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/paseka/uchasties/uchastie", name="paseka.uchasties.uchastie")
 */
class UchastieControllr extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    /**
     * @Route("", name="")
     * @param Request $request
     * @param UchastieFetcher $uchasties
     * @param PersonaFetcher $personas
     * @param MestoNomerFetcher $mestoNomers
     * @return Response
     */
    public function index(Request $request, UchastieFetcher $uchasties,
                          PersonaFetcher $personas, MestoNomerFetcher $mestoNomers
                            ): Response
    {
        $idUser = $this->getUser()->getId();

        $persona = $personas->find($idUser);

        $mestoNomer = $mestoNomers->find($idUser);

        $uchastie = $uchasties->find($idUser);

        return $this->render('app/paseka/uchasties/uchastie/index.html.twig',
            compact('uchastie', 'persona', 'mestoNomer')
        );
    }
    /**
     * @Route("/create", name=".create")
     * @param Request $request
     * @param UserRepository $users
     * @param Create\Handler $handler
     * @return Response
     */
    public function create( Request $request, UserRepository $users, Create\Handler $handler): Response
    {
        $idUser = $this->getUser()->getId();
        $user = $users->find($idUser);

// следующие присваения перенести в Handler не можeм т.к. инфа  из $user
        $command = new Create\Command($idUser);
        $command->firstName = $user->getName()->getFirst();
        $command->lastName = $user->getName()->getLast();
        $command->email = $user->getEmail() ? $user->getEmail()->getValue() : null;

        $form = $this->createForm(Create\Form::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('paseka.uchasties.uchastie');
            } catch (\DomainException $e) {
                $this->logger->warning($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
        }

        return $this->render('app/paseka/uchasties/uchastie/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name=".show", requirements={"id"=Guid::PATTERN} )
     * @param UchastieRepository $uchasties
     * @param MestoNomerFetcher $mestoNomers
     * @return Response
     */
    public function show(UchastieRepository $uchasties, string $id): Response
    {
        $uchastie = $uchasties->get(new Id($id));
        //$infaMesto = $fetchers->infaMesto($plemmatka->getMesto());
       // dd($uchastie);
        return $this->render('app/paseka/uchasties/uchastie/show.html.twig',
            compact('uchastie')
        );
    }

}