<?php

declare(strict_types=1);

namespace App\Controller\Sait\Posts;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PostsController extends AbstractController
{
    /**
     * @Route("/sait/posts", name="sait_posts")
     * @return Response
     */
    public function index(): Response
    {
        return $this->render('sait/posts/index.html.twig');
    }
}