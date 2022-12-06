<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Mestoo;

use App\Annotation\Guid;

use App\Controller\ErrorHandler;
use App\Model\Mesto\Entity\Okrugs\Oblasts\Oblast;
use App\ReadModel\Mesto\Oblasts\Raions\RaionFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/proekt/mestoo/{oblast_id}", name="proekt.mestoo")
 * @ParamConverter("oblast", options={"id" = "oblast_id"})
 */
class RaionsController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }

    /**
     * @Route("/raions/{okrug_id},{name_ok}", name=".raions")
     * @param string $okrug_id
     * @param string $name_ok
     * @param Oblast $oblast
     * @param RaionFetcher $raions
     * @return Response
     */
    public function raions(string $okrug_id, string $name_ok, Oblast $oblast, RaionFetcher $raions): Response
    {
        //$this->denyAccessUnlessGranted(OkrugAccess::MANAGE_MEMBERS, $okrug);

       

        return $this->render('proekt/mestoo/raions.html.twig', [
            'okrug_id' => $okrug_id,
            'name_ok' => $name_ok,
            'oblast' => $oblast,
            'raions' => $raions->allOfOblast($oblast->getId()->getValue()),
        ]);
    }
}
