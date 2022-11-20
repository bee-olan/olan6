<?php

declare(strict_types=1);

namespace App\Controller\Sait\Works;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class WorksController extends AbstractController
{
    /**
     * @Route("/sait/works", name="sait_works")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('sait/works/index.html.twig');
    }
}