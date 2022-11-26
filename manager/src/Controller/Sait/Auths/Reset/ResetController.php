<?php

declare(strict_types=1);

namespace App\Controller\Sait\Auths\Reset;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResetController extends AbstractController
{
    /**
     * @Route("/sait/auths/reset", name="sait.auths.reset")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('sait/auths/reset/index.html.twig');
    }
}