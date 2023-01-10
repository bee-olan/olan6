<?php

declare(strict_types=1);

namespace App\Controller\Sezons\Godas;

use App\Annotation\Guid;

use App\Model\Sezons\UseCase\Godas\Create;
use App\ReadModel\Sezons\Godas\GodaFetcher;
use Psr\Log\LoggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


/**
 * @Route("/sezons/godas", name="sezons.godas")
 */
class GodaController extends AbstractController
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Route("", name="")
     * @param GodaFetcher $godas
     * @return Response
     */
    public function index(GodaFetcher $godas): Response
    {

        $godas = $godas->all();

        return $this->render('sezons/godas/index.html.twig', compact('godas'));
    }

    /**
     * @Route("/create", name=".create")
     * @param GodaFetcher $godas
     * @param Request $request
     * @param Create\Handler $handler
     * @return Response
     */
    public function create(Request $request,  GodaFetcher $godas, Create\Handler $handler): Response
    {
        $godMax = $godas->getMaxGod() + 1;

        if ($godMax < 2014) {
            $godMax = 2015;
        }

        $command = new Create\Command();

        $command->god = $godMax;

        $command->sezon = $godMax."-".($godMax + 1);

//        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $handler->handle($command);
                return $this->redirectToRoute('sezons.godas');
            } catch (\DomainException $e) {
                $this->logger->warning($e->getMessage(), ['exception' => $e]);
                $this->addFlash('error', $e->getMessage());
            }
//        }

        return $this->render('sezons/godas/create.html.twig', [
           // 'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name=".show", requirements={"id"=Guid::PATTERN})
     * @return Response
     */
    public function show(): Response
    {
        return $this->redirectToRoute('sezons');
    }
}
