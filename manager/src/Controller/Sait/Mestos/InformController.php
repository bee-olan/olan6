<?php

declare(strict_types=1);

namespace App\Controller\Sait\Mestos;

use App\Annotation\Guid;

use App\ReadModel\Mesto\InfaMesto\MestoNomerFetcher;
use App\Model\Mesto\Entity\InfaMesto\Id;
use App\Model\Mesto\Entity\InfaMesto\MestoNomerRepository;

use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//use App\Security\Voter\Rabota\U4astniki\OkrugAccess;
use App\Controller\ErrorHandler;


/**
 * @Route("/sait/mestos", name="sait.mestos")
 */
class InformController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }


	/**
     * @Route("/", name=".inform")
     * @return Response
     * @param MestoNomerFetcher $fetcher
     */
    public function inform(MestoNomerFetcher $fetcher): Response
    {
        if ($fetcher->exists($this->getUser()->getId())) {
            $this->addFlash('error', 'Ваш номер места расположения пасеки уже записан в БД');
            return $this->redirectToRoute('sait.mestos.show');
        }

        return $this->render('sait/mestos/inform.html.twig');
    }

        /**
     * @Route("/show", name=".show")
     * @param MestoNomerFetcher $fetchers
     * @param MestoNomerRepository $mestonomers
     * @return Response
     */
    public function show(MestoNomerFetcher $fetchers, MestoNomerRepository $mestonomers,
                         Request $request ): Response
    {
        $fetcher = $fetchers->allMestNom();

        $mestonomer = $mestonomers ->get(new Id($this->getUser()->getId()));


        return $this->render('sait/mestos/show.html.twig',
            compact('fetcher', 'mestonomer'));

    }

}
