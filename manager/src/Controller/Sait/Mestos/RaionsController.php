<?php

declare(strict_types=1);

namespace App\Controller\Sait\Mestos;

use App\Annotation\Guid;
//use App\Model\Rabota\Entity\U4astniki\Mesto\Oblasts\Raions\Id;
//use App\Model\Rabota\Entity\U4astniki\Mesto\Oblasts\Oblast;
//use App\Model\Rabota\Entity\U4astniki\Mesto\Oblasts\Raions\Raion;
//
//use App\ReadModel\Rabota\U4astniki\Mesto\Oblasts\Raions\RaionFetcher;
//use App\Security\Voter\Rabota\U4astniki\OkrugAccess;


use App\Controller\ErrorHandler;
use App\Model\Mesto\Entity\Okrugs\Oblasts\Oblast;
use App\ReadModel\Mesto\Oblasts\Raions\RaionFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sait/mestos/{oblast_id}", name="sait.mestos")
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
     * @Route("/raions/{name_ok}", name=".raions")
     * @param string $name_ok
     * @param Oblast $oblast
     * @param RaionFetcher $raions
     * @return Response
     */
    public function raions(string $name_ok, Oblast $oblast, RaionFetcher $raions): Response
    {
        //$this->denyAccessUnlessGranted(OkrugAccess::MANAGE_MEMBERS, $okrug);

       

        return $this->render('sait/mestos/raions.html.twig', [
            'name_ok' => $name_ok,
            'oblast' => $oblast,
            'raions' => $raions->allOfOblast($oblast->getId()->getValue()),
        ]);
    }
}