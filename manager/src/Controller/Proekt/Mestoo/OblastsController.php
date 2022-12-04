<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Mestoo;

use App\Annotation\Guid;

use App\Controller\ErrorHandler;
use App\Model\Mesto\Entity\Okrugs\Okrug;
use App\ReadModel\Mesto\Oblasts\OblastFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


 /**
 * @Route("/proekt/mestoo/{okrug_id}/oblasts", name="proekt.mestoo.oblasts")
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

        return $this->render('proekt/mestoo/oblasts.html.twig', [
            'okrug' => $okrug,
            'oblasts' => $oblasts->allOfOkrug($okrug->getId()->getValue()),
        ]);
    }
}
