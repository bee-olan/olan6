<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Mestoo;

use App\Annotation\Guid;

use App\Controller\ErrorHandler;
use App\Model\Mesto\Entity\Okrugs\Oblasts\Raions\Raion;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/proekt/mestoo/{raion_id}", name="proekt.mestoo")
 * @ParamConverter("raion", options={"id" = "raion_id"})
 */
class MestoController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }


    /**
     * @Route("/mesto/{okrug_id},{name_ok},{oblast_id},{name_ob}", name=".mesto")
     * @param string $name_ok
     * @param string $okrug_id
     * @param string $oblast_id
     * @param string $name_ob
     * @param Raion $raion
     * @return Response
     */
    public function mesto(string $okrug_id, string $name_ok, string $oblast_id, string $name_ob,  Raion $raion): Response
    {
        //$this->denyAccessUnlessGranted(OkrugAccess::MANAGE_MEMBERS, $okrug);

        return $this->render('proekt/mestoo/mesto.html.twig', [
            'okrug_id' => $okrug_id,
            'name_ok' => $name_ok,
            'oblast_id' => $oblast_id,
            'name_ob' => $name_ob,
            'raion' => $raion,
        ]);
    }
}
