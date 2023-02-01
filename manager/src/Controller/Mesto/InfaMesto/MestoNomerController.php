<?php

declare(strict_types=1);

namespace App\Controller\Mesto\InfaMesto;

use App\Controller\ErrorHandler;
use App\Model\Mesto\Entity\InfaMesto\Id;
use App\Model\Mesto\Entity\InfaMesto\MestoNomerRepository;
use App\ReadModel\Mesto\InfaMesto\MestoNomerFetcher;

use App\Model\User\Entity\User\User;
use App\Model\Mesto\UseCase\InfaMesto\Create;

use App\Annotation\Guid;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mesto/infamesto", name="mesto.infamesto")
 */
class MestoNomerController  extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("/create/{raion_id},{mestonomer}", name=".create")
     * @param User $user
     * @param MestoNomerFetcher $fetcher
     * @param string  $raion_id
     * @param string  $mestonomer
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(string  $raion_id, string $mestonomer, Request $request, MestoNomerFetcher $fetcher, Create\Handler $handler): Response
    {

        if ($fetcher->exists($this->getUser()->getId())) {
            $this->addFlash('error', 'Ваш номер места расположения пасеки уже записан в БД');
            return $this->redirectToRoute('mesto.infamesto.show');
        }

        $command = new Create\Command($this->getUser()->getId() );

        $command = Create\Command::fromMesto($command, $raion_id, $mestonomer);

            try {
                $handler->handle($command);
                return $this->redirectToRoute('paseka.uchasties.uchastie');
            } catch (\DomainException $e) {
                $this->errors->handle($e);
                $this->addFlash('error', $e->getMessage());
            }

        return $this->render('app/mesto/infamesto/create.html.twig', [
            'mestonomer' => $mestonomer,
        ]);
    }

    /**
     * @Route("/show", name=".show")
     * @param MestoNomerFetcher $fetchers
     * @param MestoNomerRepository $mestonomers
     * @return Response
     */
    public function show(MestoNomerFetcher $fetchers, MestoNomerRepository $mestonomers,
                         Request $request ): Response
    {
        $fetcher = $fetchers->allMestNom();

        $mestonomer = $mestonomers ->get(new Id($this->getUser()->getId()));


        return $this->render('app/mesto/infamesto/show.html.twig',
            compact('fetcher', 'mestonomer'));

    }

}