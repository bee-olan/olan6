<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Sezons\Godas;

use App\Model\Paseka\Entity\Uchasties\Uchastie\Uchastie;
use App\Model\Paseka\UseCase\Sezons\Godas\UchasGoda\Add;
use App\Controller\ErrorHandler;
use App\Model\Paseka\Entity\Sezons\Godas\Goda;
use App\Model\User\Entity\User\User;
use App\ReadModel\Paseka\Sezons\Godas\GodaFetcher;
use App\ReadModel\Paseka\Sezons\Godas\UchasGodaFetcher;
use App\ReadModel\Paseka\Uchasties\PersonaFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/sezons/godas/wsegoda", name="sezons.godas.wsegoda")
 */
class WseGodaController extends AbstractController
{
    private $errors;

    public function __construct(ErrorHandler $errors)
    {
        $this->errors = $errors;
    }
    /**
     * @Route("", name="")
     * @param Request $request
     * @param UchasGodaFetcher $fetcher
     * @return Response
     */
    public function index(UchasGodaFetcher $fetcher, Request $request): Response
    {

        $uchasgodas = $fetcher->all();
//        dd($uchasgodas);
        return $this->render('sezons/godas/wsegoda/index.html.twig', [
            'uchasgodas' => $uchasgodas,
        ]);
    }


}