<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Sezons\Godas;


use App\Controller\ErrorHandler;

use App\ReadModel\Paseka\Sezons\Godas\UchasGodaFetcher;
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