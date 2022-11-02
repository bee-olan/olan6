<?php

declare(strict_types=1);

namespace App\Controller\Paseka\Uchasties\Uchastie;

use App\Annotation\Guid;

use App\Model\Paseka\Entity\Uchasties\Uchastie\Id;
use App\Model\Paseka\Entity\Uchasties\Uchastie\Uchastie;
use App\Model\Paseka\Entity\Uchasties\Uchastie\UchastieRepository;
use App\ReadModel\Mesto\InfaMesto\MestoNomerFetcher;
use App\ReadModel\Paseka\Uchasties\PersonaFetcher;
use App\ReadModel\Paseka\Uchasties\Uchastie\UchastieFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/paseka/uchasties/uchastie", name="paseka.uchasties.uchastie")
 */
class UchastieControllr extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }
    /**
     * @Route("", name="")
     * @param Request $request
     * @param UchastieFetcher $fetchers
     * @param PersonaFetcher $personas
     * @param MestoNomerFetcher $mestoNomers
     * @return Response
     */
    public function index(Request $request, UchastieFetcher $fetchers,
                          PersonaFetcher $personas, MestoNomerFetcher $mestoNomers
                            ): Response
    {

        $persona = $personas->find($this->getUser()->getId());
        //dd($persona);
        $mestoNomer = $mestoNomers->find($this->getUser()->getId());
        //dd($mestoNomer);
        if ($fetchers->exists($this->getUser()->getId() )) {
            $this->addFlash('error', 'Вы уже участник проекта .');
            return $this->redirectToRoute('paseka.uchasties.uchastie.show', ['id' => $this->getUser()->getId() ]);
        }

        return $this->render('app/paseka/uchasties/uchastie/index.html.twig',
            compact('uchastie', 'persona', 'mestoNomer')
        );
    }

    /**
     * @Route("/show/{id}", name=".show", requirements={"id"=Guid::PATTERN} )
     * @param UchastieRepository $uchasties
     * @param MestoNomerFetcher $mestoNomers
     * @return Response
     */
    public function show(UchastieRepository $uchasties, string $id): Response
    {
        $uchastie = $uchasties->get(new Id($id));
        //$infaMesto = $fetchers->infaMesto($plemmatka->getMesto());
       // dd($uchastie);
        return $this->render('app/paseka/uchasties/uchastie/show.html.twig',
            compact('uchastie')
        );
    }

}