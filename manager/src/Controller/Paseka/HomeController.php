<?php

declare(strict_types=1);

namespace App\Controller\Paseka;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/paseka/home", name="paseka")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('app/paseka/home.html.twig');
    }
}
