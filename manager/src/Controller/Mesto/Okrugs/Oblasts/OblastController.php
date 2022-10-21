<?php

declare(strict_types=1);

namespace App\Controller\Mesto\Okrugs\Oblasts;



use App\Model\Mesto\Entity\Okrugs\Okrug;
use App\ReadModel\Mesto\Oblasts\OblastFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;;

/**
 * @Route("/mesto/okrug/{okrug_id}/oblast", name="mesto.okrug.oblast")
 */
class OblastController extends AbstractController
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
    public function index(Okrug $okrug, OblastFetcher $oblasts): Response
    {

        return $this->render('app/mesto/okrug/oblast/index.html.twig', [
            'okrug' => $okrug,
            'oblasts' => $oblasts->allOfOkrug($okrug->getId()->getValue()),
        ]);
    }

}