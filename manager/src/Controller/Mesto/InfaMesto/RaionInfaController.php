<?php

declare(strict_types=1);

namespace App\Controller\Mesto\InfaMesto;

use App\Controller\ErrorHandler;
use App\Model\Mesto\Entity\Okrugs\Oblasts\Oblast;


use App\ReadModel\Mesto\Oblasts\Raions\RaionFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mesto/infamesto/oblasts/{oblast_id}", name="mesto.infamesto")
 * @ParamConverter("oblast", options={"id" = "oblast_id"})
 */
class RaionInfaController  extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("/raions/{name_ok}", name=".raions")
     * @param string $name_ok
     * @param Oblast $oblast
     * @param RaionFetcher $raions
     * @return Response
     */
    public function raions(string $name_ok, Oblast $oblast, RaionFetcher $raions): Response
    {
        //$this->denyAccessUnlessGranted(OkrugAccess::MANAGE_MEMBERS, $okrug);



        return $this->render('app/mesto/infamesto/raions.html.twig', [
            'name_ok' => $name_ok,
            'oblast' => $oblast,
            'raions' => $raions->allOfOblast($oblast->getId()->getValue()),
        ]);
    }
}
