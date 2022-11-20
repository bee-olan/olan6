<?php

declare(strict_types=1);

namespace App\Controller\Sait\Mestos;

use App\Annotation\Guid;
//use App\Model\Rabota\Entity\U4astniki\Mesto\Oblasts\Id;
//use App\Model\Rabota\Entity\U4astniki\Mesto\Okrug;
//use App\Model\Rabota\Entity\U4astniki\Mesto\Oblasts\Oblast;
//
//use App\ReadModel\Rabota\U4astniki\Mesto\Oblasts\OblastFetcher;
//use App\Security\Voter\Rabota\U4astniki\OkrugAccess;


use App\Controller\ErrorHandler;
use App\Model\Mesto\Entity\Okrugs\Okrug;
use App\ReadModel\Mesto\Oblasts\OblastFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//* @IsGranted("ROLE_RABOTA_MANAGE_MEMBERS")
/**
 * @Route("/sait/mestos", name="sait.mestos")
 */

 /**
 * @Route("/sait/mestos/{okrug_id}/oblasts", name="sait.mestos.oblasts")
 * @ParamConverter("okrug", options={"id" = "okrug_id"})
 */
class OblastsController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
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

        return $this->render('sait/mestos/oblasts.html.twig', [
            'okrug' => $okrug,
            'oblasts' => $oblasts->allOfOkrug($okrug->getId()->getValue()),
        ]);
    }
}
