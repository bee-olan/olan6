<?php

declare(strict_types=1);

namespace App\Controller\Mesto\Okrugs\Oblasts\Raions;

use App\Model\Mesto\Entity\Okrugs\Oblasts\Oblast;
use App\ReadModel\Mesto\Oblasts\Raions\RaionFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mesto/okrug/oblast/raion", name="mesto.okrug.oblast.raion")
 */
class RaionController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("", name="")
     * @param Oblast $oblast
     * @param RaionFetcher $raions
     * @return Response
     */
    public function index(Oblast $oblast, RaionFetcher $raions): Response
    {
        //$this->denyAccessUnlessGranted(OkrugAccess::MANAGE_MEMBERS, $okrug);

        return $this->render('app/mesto/okrug/oblast/raion/index.html.twig', [
            'oblast' => $oblast,
            'raions' => $raions->allOfOblast($oblast->getId()->getValue()),
        ]);
    }


}