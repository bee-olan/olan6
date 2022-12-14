<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\Rasas;

use App\Annotation\Guid;
use App\Model\Paseka\Entity\Rasas\Linias\Id;
use App\Model\Paseka\Entity\Rasas\Rasa;
use App\Model\Paseka\UseCase\Rasas\Linias\Create;
use App\Model\Paseka\UseCase\Rasas\Linias\Edit;
use App\Model\Paseka\UseCase\Rasas\Linias\Remove;
use App\ReadModel\Paseka\Rasas\Linias\LiniaFetcher;
//use App\Security\Voter\Paseka\Rasas\MateriAccess;
use App\Controller\ErrorHandler;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/proekt/pasekas/rasas/{id}/linias", name="proekt.pasekas.rasas.linias")
 */
class LiniaController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    /**
     * @Route("", name="")
     * @param Rasa $rasa
     * @param Request $request
     * @param LiniaFetcher $linias
     * @return Response
     */
    public function index( Rasa $rasa, Request $request,  LiniaFetcher $linias): Response
    {
        //$this->denyAccessUnlessGranted(MateriAccess::MANAGE_MEMBERS, $materi);
//dd($linias->allOfRasa($rasa->getId()->getValue()));
        //dd($rasa);
        return $this->render('app/paseka/rasas/linias/index.html.twig', [
            'rasa' => $rasa,
            'linias' => $linias->allOfRasa($rasa->getId()->getValue()),
        ]);
    }

    /**
     * @Route("/plemmatka", name=".plemmatka")
     * @param Rasa $rasa
     * @param Request $request
     * @param LiniaFetcher $linias
     * @return Response
     */
    public function plemmatka( Rasa $rasa, Request $request,  LiniaFetcher $linias ): Response
    {
        return $this->render('proekt/pasekas/rasas/linias/plemmatka.html.twig', [
            'rasa' => $rasa,
            'linias' => $linias->allOfRasa($rasa->getId()->getValue()),
        ]);
    }

    /**
     * @Route("/{linia_id}", name=".show", requirements={"linia_id"=Guid::PATTERN})
     * @param Rasa $rasa
     * @return Response
     */
    public function show(Rasa $rasa): Response
    {
        return $this->redirectToRoute('paseka.rasas.linias',
				['id' => $rasa->getId()]);
    }
}
