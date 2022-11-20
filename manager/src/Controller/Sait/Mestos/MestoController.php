<?php

declare(strict_types=1);

namespace App\Controller\Sait\Mestos;

use App\Annotation\Guid;

use App\Controller\ErrorHandler;
use App\Model\Mesto\Entity\Okrugs\Oblasts\Raions\Raion;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sait/mestos/{raion_id}", name="sait.mestos")
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
     * @Route("/mesto/{name_ok},{name_ob}", name=".mesto")
     * @param string $name_ok
     * @param string $name_ob
     * @param Raion $raion
     * @return Response
     */
    public function mesto(string $name_ok, string $name_ob,  Raion $raion): Response
    {
        //$this->denyAccessUnlessGranted(OkrugAccess::MANAGE_MEMBERS, $okrug);

        return $this->render('sait/mestos/mesto.html.twig', [
            'name_ok' => $name_ok,
            'name_ob' => $name_ob,
            'raion' => $raion,
        ]);
    }
}
