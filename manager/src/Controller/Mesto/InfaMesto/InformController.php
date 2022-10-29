<?php

declare(strict_types=1);

namespace App\Controller\Mesto\InfaMesto;

use Psr\Log\LoggerInterface;
//use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/mesto/infamesto", name="mesto.infamesto")
 */
class InformController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


    /**
     * @Route("/", name=".inform")
     * @return Response
     */
    public function inform(): Response
    {
        return $this->render('app/mesto/infamesto/inform.html.twig');
    }
}
