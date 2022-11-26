<?php

declare(strict_types=1);

namespace App\Controller\Sait\Auths\Signup;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SignupController extends AbstractController
{
    /**
     * @Route("/sait/auths/signup", name="sait.auths.signup")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('sait/auths/signup/index.html.twig');
    }
}