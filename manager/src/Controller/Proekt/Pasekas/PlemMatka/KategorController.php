<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\PlemMatka;

use App\Annotation\Guid;

use App\Model\Paseka\Entity\Matkas\Kategoria\Permission;

use App\ReadModel\Paseka\Matkas\KategoriaFetcher;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/proekt/pasekas/matkas/kategor/kategor", name="proekt.pasekas.matkas.kategor.kategor")
 */
class KategorController extends AbstractController
{
 
    /**
     * @Route("/", name="")
     * @param Request $request
     * @param KategoriaFetcher $kategoria
     * @return Response
     */
    public function kategor( KategoriaFetcher $kategoria): Response
    {
        $kategorias = $kategoria->all();
       $permissions = Permission::names();

        return $this->render('proekt/pasekas/matkas/kategor/kategor.html.twig',
            compact('kategorias', 'permissions') );
    }

}