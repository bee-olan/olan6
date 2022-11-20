<?php

declare(strict_types=1);

namespace App\Controller\Sait\Mestos;

//use App\Model\Rabota\Entity\U4astniki\Mesto\Okrug;
//use App\Model\Rabota\UseCase\U4astniki\Mesto\Create;
//use App\Model\Rabota\UseCase\U4astniki\Mesto\Edit;
//use App\Model\Rabota\UseCase\U4astniki\Mesto\Remove;
//use App\ReadModel\Rabota\U4astniki\Mesto\OkrugFetcher;


use App\ReadModel\Mesto\OkrugFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sait/mestos/okrugs ", name="sait.mestos.okrugs")
 */
class OkrugsController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("", name="")
     * @param OkrugFetcher $fetcher
     * @return Response
     */
    public function okrugs(OkrugFetcher $fetcher): Response
    {
        $okrugs = $fetcher->all();
        return $this->render('sait/mestos/okrugs.html.twig', compact('okrugs'));
    }

}
