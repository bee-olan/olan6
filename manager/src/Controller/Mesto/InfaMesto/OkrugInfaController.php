<?php

declare(strict_types=1);

namespace App\Controller\Mesto\InfaMesto;


use App\Controller\ErrorHandler;
use App\ReadModel\Mesto\OkrugFetcher;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mesto/infamesto/okrugs ", name="mesto.infamesto.okrugs")
 */
class OkrugInfaController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("/", name="")
     * @param OkrugFetcher $fetcher
     * @return Response
     */
    public function okrugs(OkrugFetcher $fetcher): Response
    {
        $okrugs = $fetcher->all();
        return $this->render('app/mesto/infamesto/okrugs.html.twig', compact('okrugs'));
    }

}
