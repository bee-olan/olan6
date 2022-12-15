<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\Rasas;

use App\Annotation\Guid;
use App\Model\Paseka\Entity\Rasas\Linias\Nomers\Id;
use App\Model\Paseka\Entity\Rasas\Linias\Linia;
use App\Model\Paseka\Entity\Rasas\Linias\Nomers\Nomer;

use App\Model\Paseka\UseCase\Rasas\Linias\Nomers\Create;
use App\Model\Paseka\UseCase\Rasas\Linias\Nomers\Edit;
use App\Model\Paseka\UseCase\Rasas\Linias\Nomers\Remove;

use App\ReadModel\Paseka\Rasas\Linias\Nomers\NomerFetcher;
//use App\Security\Voter\Paseka\Materis\Linia\LiniaAccess;
use App\Controller\ErrorHandler;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/proekt/pasekas/rasas/linias/{linia_id}/nomers", name="proekt.pasekas.rasas.linias.nomers")
 * @ParamConverter("linia", options={"id" = "linia_id"})
 */
class NomerController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    /**
     * @Route("", name="")
     * @param Linia $linia
     * @param NomerFetcher $nomers
     * @return Response
     */
    public function index(Linia $linia, NomerFetcher $nomers): Response
    {

        // $this->denyAccessUnlessGranted(LiniaAccess::MANAGE_MEMBERS, $linia);
//dd( $nomers->allOfLinia($linia->getId()->getValue()));
        return $this->render('proekt/pasekas/rasas/linias/nomers/index.html.twig', [
            'linia' => $linia,
            'nomers' => $nomers->allOfLinia($linia->getId()->getValue()),
        ]);
    }

    /**
     * @Route("/plemmatka", name=".plemmatka")
     * @param Linia $linia
     * @param NomerFetcher $nomers
     * @return Response
     */
    public function plemmatka(Linia $linia, NomerFetcher $nomers): Response
    {

        return $this->render('proekt/pasekas/rasas/linias/nomers/plemmatka.html.twig', [
            'linia' => $linia,
            'nomers' => $nomers->allOfLinia($linia->getId()->getValue()),
        ]);
    }


	 /**
     * @Route("/{id}", name=".show", requirements={"id"=Guid::PATTERN}))
     * @param Linia $linia
     * @return Response
     */
    public function show(Linia $linia): Response
    {
        return $this->redirectToRoute('paseka.rasas.linias.nomers',
				['linia_id' => $linia->getId()]);
    }
}
