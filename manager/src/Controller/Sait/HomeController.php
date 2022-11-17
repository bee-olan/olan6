<?php

declare(strict_types=1);

namespace App\Controller\Sait;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/sait", name="sait")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('sait/base.html.twig');
    }
}