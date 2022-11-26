<?php

declare(strict_types=1);

namespace App\Controller\Sait\Auths\Signin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SigninController extends AbstractController
{
    /**
     * @Route("/sait/auths/signin", name="sait.auths.signin")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('sait/auths/signin/index.html.twig');
    }
}