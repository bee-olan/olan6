<?php

declare(strict_types=1);

namespace App\Controller\Mesto\InfaMesto;


use App\Model\Mesto\Entity\Okrugs\Okrug;
use App\ReadModel\Mesto\Oblasts\OblastFetcher;

use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mesto/infamesto/{okrug_id}/oblasts ", name="mesto.infamesto.oblasts")
 * @ParamConverter("okrug", options={"id" = "okrug_id"})
 */
class OblastInfaController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("", name="")
     * @param Okrug $okrug
     * @param OblastFetcher $oblasts
     * @return Response
     */
    public function oblasts(Okrug $okrug, OblastFetcher $oblasts): Response
    {
        //$this->denyAccessUnlessGranted(OkrugAccess::MANAGE_MEMBERS, $okrug);

        return $this->render('app/mesto/infamesto/oblasts.html.twig', [
            'okrug' => $okrug,
            'oblasts' => $oblasts->allOfOkrug($okrug->getId()->getValue()),
        ]);
    }
}
