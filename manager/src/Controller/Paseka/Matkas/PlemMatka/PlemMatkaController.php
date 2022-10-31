<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Matkas\PlemMatka;

use App\Annotation\Guid;

use App\Model\Paseka\Entity\Matkas\PlemMatka\PlemMatka;
use App\Model\Paseka\Entity\Matkas\Sparings\SparingRepository;
use App\Model\Paseka\Entity\Matkas\Sparings\Id as SparingId;
use App\Model\Paseka\Entity\Uchasties\Uchastie\UchastieRepository;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Id;
use App\ReadModel\Paseka\Matkas\PlemMatka\PlemMatkaFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/paseka/matkas/{id}", name="paseka.matkas.plemmatka")
 */
class PlemMatkaController extends AbstractController
{
    /**
     * @Route("", name=".show", requirements={"id"=Guid::PATTERN})
     * @param PlemMatka $plemmatka
     * @param PlemMatkaFetcher $fetchers
     * @param UchastieRepository $uchasties
     * @param SparingRepository $sparings
     * @return Response
     */
    public function show(PlemMatka $plemmatka, PlemMatkaFetcher $fetchers,
                         UchastieRepository $uchasties ,
                        SparingRepository $sparings ): Response
    {
        $uchastie = $uchasties->get(new Id($plemmatka->getUchastieId()));

        $infaSparing = $fetchers->infaSparing($plemmatka->getSparing()->getId()->getValue());

        $infaRasaNom = $fetchers->infaRasaNom($plemmatka->getRasaNomId());

       $infaMesto = $fetchers->infaMesto($plemmatka->getMesto());

        return $this->render('app/paseka/matkas/plemmatka/show.html.twig',
            compact('plemmatka', 'infaRasaNom', 'infaMesto', 'uchastie','infaSparing'));
    }
}
