<?php

declare(strict_types=1);

namespace App\Controller\Sait\Profile;

use App\ReadModel\User\UserFetcher;
use Psr\Log\LoggerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{

    private $logger;
    private $users;

    public function __construct(LoggerInterface $logger, UserFetcher $users)
    {
        $this->logger = $logger;
        $this->users = $users;
    }

    /**
     * @Route("/sait/profile", name="sait.profile")
     * @return Response
     */
    public function index(): Response
    {
        $user = $this->users->findDetail($this->getUser()->getId());
        // узнаем id залогированного пользователя

        return $this->render('sait/profile/index.html.twig', compact('user'));
    }
}