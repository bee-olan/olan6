<?php

declare(strict_types=1);

namespace App\Controller\Proekt\Pasekas\PlemMatka;

use App\Annotation\Guid;

use App\Model\Paseka\Entity\Matkas\Kategoria\Permission;
use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatka;
use App\Model\Paseka\Entity\Matkas\Sparings\SparingRepository;
use App\Model\Paseka\Entity\Matkas\Sparings\Id as SparingId;

use App\Model\Paseka\Entity\Rasas\Linias\Nomers\NomerRepository;
use App\Model\Paseka\Entity\Rasas\Linias\Nomers\Id as NomerId;

use App\Model\Paseka\Entity\Uchasties\Uchastie\UchastieRepository;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Id;
use App\ReadModel\Mesto\InfaMesto\MestoNomerFetcher;
use App\ReadModel\Paseka\Matkas\KategoriaFetcher;
use App\ReadModel\Paseka\Matkas\PlemMatka\PlemMatkaFetcher;
use App\ReadModel\Paseka\Uchasties\PersonaFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/proekt/pasekas/matkas/plemmatkas", name="proekt.pasekas.matkas.plemmatkas")
 */
class PlemMatkaController extends AbstractController
{
    /**
     * @Route("/", name="")
     * @return Response
     */
    public function index(): Response
    {

        return $this->render('proekt/pasekas/matkas/plemmatkas/index.html.twig'
//            ,
//            compact('rasas')
        );
    }

    /**
     * @Route("/plemmatka/{id}", name=".plemmatka" , requirements={"id"=Guid::PATTERN})
     * @param Request $request
     * @param NomerRepository $nomers
     * @param PersonaFetcher $personas
     * @param MestoNomerFetcher $mestoNomers
     * @param string $id
     * @return Response
     */
    public function plemmatka(string $id, Request $request,
                              PersonaFetcher $personas, MestoNomerFetcher $mestoNomers,
                              NomerRepository $nomers): Response
    {
        $idUser = $this->getUser()->getId();

        $nomer = $nomers->get(new NomerId($id));

        $persona = $personas->find($idUser);

        $mestoNomer = $mestoNomers->find($idUser);

        return $this->render('proekt/pasekas/matkas/plemmatkas/plemmatka.html.twig',
            compact('nomer', 'persona', 'mestoNomer') );
    }

    /**
     * @Route("/sdelano/{id_nom},{kategoria},{plemmatka}", name=".sdelano" , requirements={"id_nom"=Guid::PATTERN})
     * @param Request $request
     * @param NomerRepository $nomers
     * @param PersonaFetcher $personas
     * @param MestoNomerFetcher $mestoNomers
     * @param string $id_nom
     * @param string $plemmatka
     * @param string $kategoria
     * @param PlemMatkaFetcher $plemmatkas
     * @return Response
     */
    public function sdelano(string $id_nom, string $kategoria, string $plemmatka, Request $request,
                              PersonaFetcher $personas, MestoNomerFetcher $mestoNomers,
                              NomerRepository $nomers, PlemMatkaFetcher $plemmatkas): Response
    {

        $idUser = $this->getUser()->getId();

        $nomer = $nomers->get(new NomerId($id_nom));

        $persona = $personas->find($idUser);

        $mestoNomer = $mestoNomers->find($idUser);

        $plemId = $plemmatkas->findIdByPlemMatka($plemmatka);


        return $this->render('proekt/pasekas/matkas/plemmatkas/sdelano.html.twig',
            compact('kategoria', 'nomer', 'persona', 'mestoNomer', 'plemmatka', 'plemId') );
    }

   /**
    * @Route("/{plem_id}", name=".show", requirements={"plem_id"=Guid::PATTERN})
    * @param PlemMatka $plemmatka
    * @param   string $plem_id
    * @param PlemMatkaFetcher $fetchers
    * @param UchastieRepository $uchasties
    * @param KategoriaFetcher $kategoria
    * @return Response
    */
   public function show( string $plem_id, PlemMatkaFetcher $fetchers,
                        UchastieRepository $uchasties ,
                         KategoriaFetcher $kategoria ): Response
   {

      $plemmatka = $fetchers->find($plem_id);
     // dd( $plemmatka);

       $uchastie = $uchasties->get(new Id($plemmatka->getUchastieId()));

       $kategorias = $kategoria->all();
       $permissions = Permission::names();

       $infaRasaNom = $fetchers->infaRasaNom($plemmatka->getRasaNomId());

      $infaMesto = $fetchers->infaMesto($plemmatka->getMesto());

       return $this->render('proekt/pasekas/matkas/plemmatkas/show.html.twig',
           compact('plemmatka', 'infaRasaNom', 'infaMesto', 'uchastie','kategorias', 'permissions'));
   }
}
