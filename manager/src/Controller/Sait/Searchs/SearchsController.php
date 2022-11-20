<?php

declare(strict_types=1);

namespace App\Controller\Sait\Searchs;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchsController extends AbstractController
{
    /**
     * @Route("/sait/searchs", name="sait_searchs")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('sait/searchs/index.html.twig');
    }
}