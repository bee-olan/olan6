<?php

declare(strict_types=1);

namespace App\Controller\Proekt;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/proekt", name="proekt")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('proekt/base.html.twig');
    }
}